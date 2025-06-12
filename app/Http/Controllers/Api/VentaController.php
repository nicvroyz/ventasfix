<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Obtiene la lista de ventas paginada con sus relaciones
     */
    public function index()
    {
        $ventas = Venta::with(['cliente', 'detalles.producto'])
            ->latest()
            ->paginate(10);
            
        return response()->json($ventas);
    }

    /**
     * Crea una nueva venta con sus detalles
     */
    public function store(Request $request)
    {
        $request->validate(Venta::rules());
        
        try {
            DB::beginTransaction();
            
            // Crear la venta inicial
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'total' => 0,
                'estado' => 'pending',
                'observaciones' => $request->observaciones
            ]);
            
            $total = 0;
            $productos = $request->productos;
            
            // Procesar cada producto de la venta
            foreach ($productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                
                // Verificar stock disponible
                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }
                
                // Calcular subtotal y actualizar total
                $subtotal = $producto->precio_venta * $item['cantidad'];
                $total += $subtotal;
                
                // Crear detalle de venta
                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotal
                ]);
                
                // Actualizar stock del producto
                $producto->decrement('stock_actual', $item['cantidad']);
            }
            
            // Actualizar total de la venta
            $venta->update(['total' => $total]);
            
            DB::commit();
            
            return response()->json($venta->load(['cliente', 'detalles.producto']), 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la venta: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Muestra los detalles de una venta específica
     */
    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'detalles.producto']);
        return response()->json($venta);
    }

    /**
     * Actualiza una venta pendiente y sus detalles
     */
    public function update(Request $request, Venta $venta)
    {
        if ($venta->estado !== 'pending') {
            return response()->json([
                'message' => 'Solo se pueden editar ventas pendientes'
            ], 422);
        }
        
        $request->validate(Venta::rules($venta->id));
        
        try {
            DB::beginTransaction();
            
            // Restaurar stock de productos anteriores
            foreach ($venta->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->increment('stock_actual', $detalle->cantidad);
            }
            
            // Eliminar detalles actuales
            $venta->detalles()->delete();
            
            // Actualizar datos básicos de la venta
            $venta->update([
                'cliente_id' => $request->cliente_id,
                'total' => 0,
                'observaciones' => $request->observaciones
            ]);
            
            // Procesar nuevos productos
            $total = 0;
            $productos = $request->productos;
            
            foreach ($productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                
                // Verificar stock disponible
                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }
                
                // Calcular subtotal y actualizar total
                $subtotal = $producto->precio_venta * $item['cantidad'];
                $total += $subtotal;
                
                // Crear nuevo detalle
                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotal
                ]);
                
                // Actualizar stock del producto
                $producto->decrement('stock_actual', $item['cantidad']);
            }
            
            // Actualizar total de la venta
            $venta->update(['total' => $total]);
            
            DB::commit();
            
            return response()->json($venta->load(['cliente', 'detalles.producto']));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar la venta: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Elimina una venta pendiente
     */
    public function destroy(Venta $venta)
    {
        if ($venta->estado !== 'pending') {
            return response()->json([
                'message' => 'Solo se pueden eliminar ventas pendientes'
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Restaurar stock de productos
            foreach ($venta->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->increment('stock_actual', $detalle->cantidad);
            }
            
            // Eliminar detalles y venta
            $venta->detalles()->delete();
            $venta->delete();
            
            DB::commit();
            
            return response()->json(null, 204);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar la venta: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Actualiza el estado de una venta
     */
    public function updateStatus(Request $request, Venta $venta)
    {
        $request->validate([
            'estado' => 'required|in:pending,completed,cancelled'
        ]);
        
        if ($venta->estado === $request->estado) {
            return response()->json([
                'message' => 'La venta ya tiene ese estado'
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Si se cancela la venta, restaurar stock
            if ($request->estado === 'cancelled') {
                foreach ($venta->detalles as $detalle) {
                    $producto = $detalle->producto;
                    $producto->increment('stock_actual', $detalle->cantidad);
                }
            }
            
            $venta->update(['estado' => $request->estado]);
            
            DB::commit();
            
            return response()->json($venta->load(['cliente', 'detalles.producto']));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 422);
        }
    }
} 
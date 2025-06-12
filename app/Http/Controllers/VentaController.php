<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with(['cliente', 'detalles.producto'])
            ->latest()
            ->paginate(10);
            
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('razon_social')->get();
        $productos = Producto::where('stock_actual', '>', 0)
            ->orderBy('nombre')
            ->get();
            
        return view('ventas.create', compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Venta::rules());
        
        try {
            DB::beginTransaction();
            
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'total' => 0,
                'estado' => 'pending',
                'observaciones' => $request->observaciones
            ]);
            
            $total = 0;
            $productos = $request->productos;
            
            foreach ($productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                
                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }
                
                $subtotal = $producto->precio_venta * $item['cantidad'];
                $total += $subtotal;
                
                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotal
                ]);
                
                $producto->decrement('stock_actual', $item['cantidad']);
            }
            
            $venta->update(['total' => $total]);
            
            DB::commit();
            
            return redirect()
                ->route('ventas.show', $venta)
                ->with('success', 'Venta creada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'detalles.producto']);
        return view('ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        if ($venta->estado !== 'pending') {
            return redirect()
                ->route('ventas.show', $venta)
                ->with('error', 'Solo se pueden editar ventas pendientes');
        }
        
        $venta->load(['cliente', 'detalles.producto']);
        $clientes = Cliente::orderBy('razon_social')->get();
        $productos = Producto::where('stock_actual', '>', 0)
            ->orWhereIn('id', $venta->detalles->pluck('producto_id'))
            ->orderBy('nombre')
            ->get();
            
        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        if ($venta->estado !== 'pending') {
            return redirect()
                ->route('ventas.show', $venta)
                ->with('error', 'Solo se pueden editar ventas pendientes');
        }
        
        $request->validate(Venta::rules($venta->id));
        
        try {
            DB::beginTransaction();
            
            // Restaurar stock de productos
            foreach ($venta->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->increment('stock_actual', $detalle->cantidad);
            }
            
            // Eliminar detalles actuales
            $venta->detalles()->delete();
            
            // Actualizar venta
            $venta->update([
                'cliente_id' => $request->cliente_id,
                'total' => 0,
                'observaciones' => $request->observaciones
            ]);
            
            // Crear nuevos detalles
            $total = 0;
            $productos = $request->productos;
            
            foreach ($productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                
                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }
                
                $subtotal = $producto->precio_venta * $item['cantidad'];
                $total += $subtotal;
                
                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotal
                ]);
                
                $producto->decrement('stock_actual', $item['cantidad']);
            }
            
            $venta->update(['total' => $total]);
            
            DB::commit();
            
            return redirect()
                ->route('ventas.show', $venta)
                ->with('success', 'Venta actualizada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        if ($venta->estado !== 'pending') {
            return redirect()
                ->route('ventas.index')
                ->with('error', 'Solo se pueden eliminar ventas pendientes');
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
            
            return redirect()
                ->route('ventas.index')
                ->with('success', 'Venta eliminada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Venta $venta)
    {
        $request->validate([
            'estado' => 'required|in:pending,completed,cancelled'
        ]);
        
        if ($venta->estado === $request->estado) {
            return back()->with('info', 'La venta ya tiene ese estado');
        }
        
        try {
            DB::beginTransaction();
            
            if ($request->estado === 'cancelled') {
                // Restaurar stock de productos
                foreach ($venta->detalles as $detalle) {
                    $producto = $detalle->producto;
                    $producto->increment('stock_actual', $detalle->cantidad);
                }
            }
            
            $venta->update(['estado' => $request->estado]);
            
            DB::commit();
            
            return back()->with('success', 'Estado de la venta actualizado exitosamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }
}

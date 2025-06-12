<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    /**
     * Obtiene la lista de productos paginada
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Producto::all());
    }

    /**
     * Crea un nuevo producto
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:productos',
            'nombre' => 'required',
            'descripcion_corta' => 'required',
            'descripcion_larga' => 'required',
            'imagen' => 'required|image|max:2048',
            'precio_neto' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_bajo' => 'required|integer|min:0',
            'stock_alto' => 'required|integer|min:0'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen_url'] = Storage::url($path);
        }

        $validated['precio_venta'] = $validated['precio_neto'] * 1.19; // Aplicar IVA 19%

        $producto = Producto::create($validated);
        return response()->json($producto, 201);
    }

    /**
     * Muestra los detalles de un producto específico
     * 
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto);
    }

    /**
     * Actualiza la información de un producto
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $validated = $request->validate([
            'sku' => ['required', Rule::unique('productos')->ignore($id)],
            'nombre' => 'required',
            'descripcion_corta' => 'required',
            'descripcion_larga' => 'required',
            'imagen' => 'nullable|image|max:2048',
            'precio_neto' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_bajo' => 'required|integer|min:0',
            'stock_alto' => 'required|integer|min:0'
        ]);

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen_url) {
                Storage::delete(str_replace('/storage/', 'public/', $producto->imagen_url));
            }
            
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen_url'] = Storage::url($path);
        }

        $validated['precio_venta'] = $validated['precio_neto'] * 1.19; // Aplicar IVA 19%

        $producto->update($validated);
        return response()->json($producto);
    }

    /**
     * Elimina un producto
     * 
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        // Eliminar imagen si existe
        if ($producto->imagen_url) {
            Storage::delete(str_replace('/storage/', 'public/', $producto->imagen_url));
        }
        
        $producto->delete();
        return response()->json(null, 204);
    }

    public function updateStock(Request $request, Producto $producto)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'tipo' => 'required|in:increment,decrement'
        ]);

        if ($request->tipo === 'decrement' && $producto->stock_actual < $request->cantidad) {
            return response()->json([
                'message' => 'Stock insuficiente'
            ], 422);
        }

        $producto->update([
            'stock_actual' => $request->tipo === 'increment' 
                ? $producto->stock_actual + $request->cantidad
                : $producto->stock_actual - $request->cantidad
        ]);

        return response()->json($producto);
    }
} 
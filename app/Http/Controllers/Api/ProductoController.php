<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(10);
        return response()->json($productos);
    }

    public function store(Request $request)
    {
        $request->validate(Producto::rules());

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);

        return response()->json($producto, 201);
    }

    public function show(Producto $producto)
    {
        return response()->json($producto);
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate(Producto::rules($producto->id));

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return response()->json($producto);
    }

    public function destroy(Producto $producto)
    {
        // Eliminar imagen si existe
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
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
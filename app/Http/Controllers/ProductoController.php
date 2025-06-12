<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $productos = Producto::latest()->paginate(10);
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Almacena un nuevo producto en la base de datos
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate(Producto::rules());
            
            // Generar SKU si no se proporciona
            if (empty($validated['sku'])) {
                $validated['sku'] = 'SKU-' . strtoupper(substr(md5(uniqid()), 0, 8));
            }
            
            // Calcular precio de venta con IVA
            $validated['precio_venta'] = $validated['precio_neto'] * 1.19;
            
            // Manejar la imagen si se proporciona
            if ($request->hasFile('imagen')) {
                $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
            }
            
            $producto = Producto::create($validated);
            
            return redirect()->route('productos.index')
                ->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el producto: ' . $e->getMessage());
        }
    }

    /**
     * Muestra los detalles de un producto específico
     * 
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para editar un producto
     * 
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualiza la información de un producto en la base de datos
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Producto $producto)
    {
        try {
            $request->validate(Producto::rules($producto->id));

            $producto->update($request->all());

            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($producto->imagen) {
                    Storage::disk('public')->delete($producto->imagen);
                }
                $producto->imagen = $request->file('imagen')->store('productos', 'public');
                $producto->save();
            }

            return redirect()->route('productos.index')
                ->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Elimina un producto de la base de datos
     * 
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Producto $producto)
    {
        try {
            // Eliminar imagen si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $producto->delete();

            return redirect()->route('productos.index')
                ->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}

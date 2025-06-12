<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Muestra la lista de clientes
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $clientes = Cliente::latest()->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Muestra el formulario para crear un nuevo cliente
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Almacena un nuevo cliente en la base de datos
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Cliente::rules());

        $cliente = Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Muestra los detalles de un cliente específico
     * 
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\View\View
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Muestra el formulario para editar un cliente
     * 
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\View\View
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualiza la información de un cliente en la base de datos
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate(Cliente::rules($cliente->id));

        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Elimina un cliente de la base de datos
     * 
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Cliente $cliente)
    {
        try {
            if ($cliente->delete()) {
                return redirect()->route('clientes.index')
                    ->with('success', 'Cliente eliminado exitosamente.');
            }

            return redirect()->route('clientes.index')
                ->with('error', 'No se pudo eliminar el cliente. Por favor, intente nuevamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }
}

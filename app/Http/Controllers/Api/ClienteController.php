<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Obtiene la lista de clientes paginada con conteo de ventas y total
     */
    public function index()
    {
        $clientes = Cliente::withCount('ventas')
            ->withSum('ventas', 'total')
            ->paginate(10);
            
        return response()->json($clientes);
    }

    /**
     * Crea un nuevo cliente
     */
    public function store(Request $request)
    {
        $request->validate(Cliente::rules());

        $cliente = Cliente::create($request->all());

        return response()->json($cliente, 201);
    }

    /**
     * Muestra los detalles de un cliente específico con sus últimas ventas
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['ventas' => function($query) {
            $query->latest()->take(5);
        }]);
        
        return response()->json($cliente);
    }

    /**
     * Actualiza los datos de un cliente
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate(Cliente::rules($cliente->id));

        $cliente->update($request->all());

        return response()->json($cliente);
    }

    /**
     * Elimina un cliente si no tiene ventas asociadas
     */
    public function destroy(Cliente $cliente)
    {
        if ($cliente->ventas()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar el cliente porque tiene ventas asociadas'
            ], 422);
        }

        $cliente->delete();
        return response()->json(null, 204);
    }

    /**
     * Obtiene el historial de ventas de un cliente
     */
    public function ventas(Cliente $cliente)
    {
        $ventas = $cliente->ventas()
            ->with('detalles.producto')
            ->latest()
            ->paginate(10);
            
        return response()->json($ventas);
    }
} 
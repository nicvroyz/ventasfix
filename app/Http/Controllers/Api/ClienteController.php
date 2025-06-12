<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Services\LogService;
use App\Traits\Validaciones;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    use Validaciones;

    /**
     * Obtiene la lista de clientes paginada
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clientes = Cliente::all();
        LogService::log('Listar clientes', 'Cliente', ['total' => $clientes->count()]);
        return response()->json($clientes);
    }

    /**
     * Crea un nuevo cliente
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'rut_empresa' => ['required', 'unique:clientes', function ($attribute, $value, $fail) {
                    if (!$this->validarRut($value)) {
                        $fail('El RUT de la empresa no es válido.');
                    }
                }],
                'rubro' => 'required|string|max:255',
                'razon_social' => 'required|string|max:255',
                'telefono' => $this->reglasTelefono(),
                'direccion' => 'required|string|max:255',
                'nombre_contacto' => 'required|string|max:255',
                'email_contacto' => 'required|email'
            ]);

            $cliente = Cliente::create($validated);
            
            LogService::log('Crear cliente', 'Cliente', [
                'cliente_id' => $cliente->id,
                'razon_social' => $cliente->razon_social
            ]);

            return response()->json($cliente, 201);
        } catch (\Exception $e) {
            LogService::error('Error al crear cliente', $e, $request->all());
            return response()->json(['message' => 'Error al crear el cliente'], 500);
        }
    }

    /**
     * Muestra los detalles de un cliente específico
     * 
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        LogService::log('Ver cliente', 'Cliente', ['cliente_id' => $id]);
        return response()->json($cliente);
    }

    /**
     * Actualiza la información de un cliente
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            
            $validated = $request->validate([
                'rut_empresa' => ['required', Rule::unique('clientes')->ignore($id), function ($attribute, $value, $fail) {
                    if (!$this->validarRut($value)) {
                        $fail('El RUT de la empresa no es válido.');
                    }
                }],
                'rubro' => 'required|string|max:255',
                'razon_social' => 'required|string|max:255',
                'telefono' => $this->reglasTelefono(),
                'direccion' => 'required|string|max:255',
                'nombre_contacto' => 'required|string|max:255',
                'email_contacto' => 'required|email'
            ]);

            $cliente->update($validated);
            
            LogService::log('Actualizar cliente', 'Cliente', [
                'cliente_id' => $id,
                'razon_social' => $cliente->razon_social
            ]);

            return response()->json($cliente);
        } catch (\Exception $e) {
            LogService::error('Error al actualizar cliente', $e, [
                'cliente_id' => $id,
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'Error al actualizar el cliente'], 500);
        }
    }

    /**
     * Elimina un cliente
     * 
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();
            
            LogService::log('Eliminar cliente', 'Cliente', ['cliente_id' => $id]);
            
            return response()->json(null, 204);
        } catch (\Exception $e) {
            LogService::error('Error al eliminar cliente', $e, ['cliente_id' => $id]);
            return response()->json(['message' => 'Error al eliminar el cliente'], 500);
        }
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
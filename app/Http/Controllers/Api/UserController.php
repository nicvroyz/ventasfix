<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LogService;
use App\Traits\Validaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use Validaciones;

    /**
     * Obtiene la lista de usuarios paginada
     */
    public function index()
    {
        $users = User::all();
        LogService::log('Listar usuarios', 'User', ['total' => $users->count()]);
        return response()->json($users);
    }

    /**
     * Crea un nuevo usuario
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'rut' => ['required', 'unique:users', function ($attribute, $value, $fail) {
                    if (!$this->validarRut($value)) {
                        $fail('El RUT ingresado no es válido.');
                    }
                }],
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => ['required', 'email', 'unique:users', 'ends_with:@ventasfix.cl'],
                'password' => $this->reglasPassword()
            ]);

            $validated['password'] = Hash::make($validated['password']);
            
            $user = User::create($validated);
            
            LogService::log('Crear usuario', 'User', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return response()->json($user, 201);
        } catch (\Exception $e) {
            LogService::error('Error al crear usuario', $e, $request->all());
            return response()->json(['message' => 'Error al crear el usuario'], 500);
        }
    }

    /**
     * Muestra los detalles de un usuario específico
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        LogService::log('Ver usuario', 'User', ['user_id' => $id]);
        return response()->json($user);
    }

    /**
     * Actualiza los datos de un usuario
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $validated = $request->validate([
                'rut' => ['required', Rule::unique('users')->ignore($id), function ($attribute, $value, $fail) {
                    if (!$this->validarRut($value)) {
                        $fail('El RUT ingresado no es válido.');
                    }
                }],
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => ['required', 'email', 'ends_with:@ventasfix.cl', Rule::unique('users')->ignore($id)],
                'password' => array_merge(['nullable'], $this->reglasPassword())
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);
            
            LogService::log('Actualizar usuario', 'User', [
                'user_id' => $id,
                'email' => $user->email
            ]);

            return response()->json($user);
        } catch (\Exception $e) {
            LogService::error('Error al actualizar usuario', $e, [
                'user_id' => $id,
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'Error al actualizar el usuario'], 500);
        }
    }

    /**
     * Elimina un usuario
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            LogService::log('Eliminar usuario', 'User', ['user_id' => $id]);
            
            return response()->json(null, 204);
        } catch (\Exception $e) {
            LogService::error('Error al eliminar usuario', $e, ['user_id' => $id]);
            return response()->json(['message' => 'Error al eliminar el usuario'], 500);
        }
    }
} 
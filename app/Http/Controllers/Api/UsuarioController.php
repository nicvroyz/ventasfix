<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UsuarioController extends Controller
{
    /**
     * Obtiene la lista de usuarios paginada
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $usuarios = User::latest()->paginate(10);
        return response()->json($usuarios);
    }

    /**
     * Crea un nuevo usuario
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate(User::rules());

        $usuario = User::create([
            'rut' => $request->rut,
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($usuario, 201);
    }

    /**
     * Muestra los detalles de un usuario específico
     * 
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * Actualiza la información de un usuario
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate(User::rules($usuario->id));

        $usuario->update([
            'rut' => $request->rut,
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $usuario->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json($usuario);
    }

    /**
     * Elimina un usuario
     * 
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return response()->json(null, 204);
    }
} 
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
     */
    public function index()
    {
        $usuarios = User::latest()->paginate(10);
        return response()->json($usuarios);
    }

    /**
     * Crea un nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($usuario, 201);
    }

    /**
     * Muestra los detalles de un usuario específico
     */
    public function show(User $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * Actualiza la información de un usuario
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $usuario->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $usuario->update([
            'name' => $request->name,
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
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return response()->json(null, 204);
    }
} 
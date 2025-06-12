<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Ejecuta el seeder.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@ventasfix.cl')->exists()) {
            User::create([
                'rut' => '11111111-1',
                'nombre' => 'Administrador',
                'apellido' => 'Sistema',
                'email' => 'admin@ventasfix.cl',
                'password' => Hash::make('admin123'),
            ]);
        }
    }
} 
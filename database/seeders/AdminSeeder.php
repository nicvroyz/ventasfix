<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@ventasfix.cl',
            'password' => Hash::make('admin123'),
            'rut' => '11111111-1'
        ]);
    }
} 
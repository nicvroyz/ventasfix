<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Ejecuta el seeder.
     */
    public function run(): void
    {
        $clientes = [
            [
                'rut_empresa' => '76.123.456-7',
                'rubro' => 'Tecnología',
                'razon_social' => 'Tech Solutions SpA',
                'telefono' => '+56 2 2345 6789',
                'direccion' => 'Av. Providencia 1234, Santiago',
                'nombre_contacto' => 'Juan Pérez',
                'email_contacto' => 'juan.perez@techsolutions.cl'
            ],
            [
                'rut_empresa' => '77.234.567-8',
                'rubro' => 'Construcción',
                'razon_social' => 'Constructora Edificios Ltda',
                'telefono' => '+56 2 3456 7890',
                'direccion' => 'Av. Las Condes 5678, Santiago',
                'nombre_contacto' => 'María González',
                'email_contacto' => 'maria.gonzalez@constructora.cl'
            ],
            [
                'rut_empresa' => '78.345.678-9',
                'rubro' => 'Alimentación',
                'razon_social' => 'Distribuidora Alimentos SA',
                'telefono' => '+56 2 4567 8901',
                'direccion' => 'Av. La Dehesa 9012, Santiago',
                'nombre_contacto' => 'Carlos Rodríguez',
                'email_contacto' => 'carlos.rodriguez@alimentos.cl'
            ]
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
} 
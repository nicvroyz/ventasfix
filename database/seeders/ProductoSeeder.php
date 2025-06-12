<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Ejecuta el seeder.
     */
    public function run(): void
    {
        $productos = [
            [
                'sku' => 'LP-HP-001',
                'nombre' => 'Laptop HP ProBook',
                'precio_neto' => 699990,
                'precio_venta' => 832989, // precio_neto * 1.19 (IVA)
                'stock_actual' => 15,
                'stock_minimo' => 5,
                'stock_bajo' => 10,
                'stock_alto' => 20,
                'descripcion_corta' => 'Laptop HP ProBook 450 G8, Intel Core i5, 8GB RAM, 256GB SSD',
                'descripcion_larga' => 'Laptop HP ProBook 450 G8 con procesador Intel Core i5 de 11va generación, 8GB de RAM, almacenamiento SSD de 256GB, pantalla de 15.6" Full HD, Windows 10 Pro.'
            ],
            [
                'sku' => 'MN-DL-001',
                'nombre' => 'Monitor Dell 24"',
                'precio_neto' => 199990,
                'precio_venta' => 237989, // precio_neto * 1.19 (IVA)
                'stock_actual' => 25,
                'stock_minimo' => 8,
                'stock_bajo' => 15,
                'stock_alto' => 30,
                'descripcion_corta' => 'Monitor Dell 24" Full HD, HDMI, VGA',
                'descripcion_larga' => 'Monitor Dell 24" con resolución Full HD (1920x1080), puertos HDMI y VGA, tiempo de respuesta de 5ms, ángulo de visión de 178°, panel IPS.'
            ],
            [
                'sku' => 'TC-LG-001',
                'nombre' => 'Teclado Mecánico Logitech',
                'precio_neto' => 49990,
                'precio_venta' => 59489, // precio_neto * 1.19 (IVA)
                'stock_actual' => 30,
                'stock_minimo' => 10,
                'stock_bajo' => 20,
                'stock_alto' => 40,
                'descripcion_corta' => 'Teclado mecánico Logitech G Pro, RGB, switches GX Blue',
                'descripcion_larga' => 'Teclado mecánico Logitech G Pro con switches GX Blue, iluminación RGB personalizable, diseño compacto, cable desmontable, compatible con Windows y Mac.'
            ],
            [
                'sku' => 'MS-RZ-001',
                'nombre' => 'Mouse Gaming Razer',
                'precio_neto' => 39990,
                'precio_venta' => 47589, // precio_neto * 1.19 (IVA)
                'stock_actual' => 20,
                'stock_minimo' => 8,
                'stock_bajo' => 15,
                'stock_alto' => 25,
                'descripcion_corta' => 'Mouse gaming Razer DeathAdder V2, 20K DPI, RGB',
                'descripcion_larga' => 'Mouse gaming Razer DeathAdder V2 con sensor óptico de 20,000 DPI, 8 botones programables, iluminación RGB Chroma, cable Speedflex, compatible con Windows y Mac.'
            ]
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
} 
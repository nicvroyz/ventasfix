<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'nombre',
        'descripcion_corta',
        'descripcion_larga',
        'imagen',
        'precio_neto',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'stock_bajo',
        'stock_alto'
    ];

    public static function rules($id = null)
    {
        return [
            'sku' => ['required', 'string', 'unique:productos,sku,' . $id],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion_corta' => ['required', 'string', 'max:255'],
            'descripcion_larga' => ['required', 'string'],
            'imagen' => ['nullable', 'image', 'max:2048'], // 2MB max
            'precio_neto' => ['required', 'numeric', 'min:0'],
            'precio_venta' => ['required', 'numeric', 'min:0'],
            'stock_actual' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'stock_bajo' => ['required', 'integer', 'min:0'],
            'stock_alto' => ['required', 'integer', 'min:0'],
        ];
    }

    // Calcular el precio de venta con IVA (19%)
    public function calcularPrecioVenta()
    {
        return $this->precio_neto * 1.19;
    }

    // Verificar si el stock está bajo
    public function stockBajo()
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    // Verificar si el stock está alto
    public function stockAlto()
    {
        return $this->stock_actual >= $this->stock_alto;
    }

    // Verificar si el stock está en nivel crítico (por debajo del stock bajo)
    public function stockCritico()
    {
        return $this->stock_actual <= $this->stock_bajo;
    }
}

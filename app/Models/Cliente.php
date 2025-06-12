<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'rut_empresa',
        'rubro',
        'razon_social',
        'telefono',
        'direccion',
        'nombre_contacto',
        'email_contacto'
    ];

    public static function rules($id = null)
    {
        return [
            'rut_empresa' => ['required', 'string', 'unique:clientes,rut_empresa,' . $id],
            'rubro' => ['required', 'string', 'max:255'],
            'razon_social' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'nombre_contacto' => ['required', 'string', 'max:255'],
            'email_contacto' => ['required', 'email', 'max:255'],
        ];
    }

    // Relación con ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    // Obtener el total de ventas del cliente
    public function totalVentas()
    {
        return $this->ventas()->sum('total');
    }

    // Obtener la última venta del cliente
    public function ultimaVenta()
    {
        return $this->ventas()->latest()->first();
    }
}

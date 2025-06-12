<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'rut_empresa',
        'rubro',
        'razon_social',
        'telefono',
        'direccion',
        'nombre_contacto',
        'email_contacto'
    ];

    protected $dates = ['deleted_at'];

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
}

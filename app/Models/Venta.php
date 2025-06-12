<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'total',
        'estado',
        'observaciones'
    ];

    public static function rules($id = null)
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'total' => 'required|numeric|min:0',
            'estado' => 'required|in:pending,completed,cancelled',
            'observaciones' => 'nullable|string|max:500'
        ];
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'venta_detalles')
            ->withPivot('cantidad', 'precio_unitario', 'subtotal')
            ->withTimestamps();
    }

    public function getEstadoBadgeAttribute()
    {
        return match($this->estado) {
            'pending' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    public function getEstadoTextAttribute()
    {
        return match($this->estado) {
            'pending' => 'Pendiente',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada',
            default => 'Desconocido'
        };
    }

    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 0, ',', '.');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}

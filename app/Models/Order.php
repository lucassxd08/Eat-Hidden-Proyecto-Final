<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id', 'delivery_id', 'status',
        'total', 'delivery_address', 'notes',
        'metodo_pago', 'estado_pago', 'fecha_pago',
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'total' => 'decimal:2',
    ];

    public static array $statuses = [
        'pending'    => 'Pendiente',
        'confirmed'  => 'Confirmado',
        'preparing'  => 'En cocina',
        'ready'      => 'Listo para entrega',
        'delivering' => 'En camino',
        'delivered'  => 'Entregado',
        'cancelled'  => 'Cancelado',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(User::class, 'delivery_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::$statuses[$this->status] ?? $this->status;
    }
}

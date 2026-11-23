<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'service_id',
        'product_name',
        'product_image',
        'unit_price',
        'quantity',
        'color',
        'size_type',
        'size_label',
        'custom_measurements',
        'line_total',
    ];

    protected $casts = [
        'custom_measurements' => 'array',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

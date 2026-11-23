<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'series',
        'description',
        'price',
        'fabric_need_meter',
        'image_path',
        'gallery_images',
        'available_colors',
        'standard_sizes',
        'allow_custom_size',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'available_colors' => 'array',
        'standard_sizes' => 'array',
        'allow_custom_size' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

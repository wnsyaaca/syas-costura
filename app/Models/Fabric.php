<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    protected $fillable = ['name', 'texture', 'color_name', 'color_hex', 'image_path', 'price_per_meter'];

    public function orders() { return $this->hasMany(Order::class); }
}

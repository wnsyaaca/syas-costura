<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['customer_id', 'size_name', 'dimensions_label', 'measurement_unit'];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function orders() { return $this->hasMany(Order::class); }
}

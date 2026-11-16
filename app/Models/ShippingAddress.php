<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = ['order_id', 'recipient_name', 'full_address', 'city', 'postal_code'];

    public function order()
    {return $this->belongsTo(Order::class);}
}

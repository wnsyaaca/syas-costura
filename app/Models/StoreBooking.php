<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBooking extends Model
{
    protected $fillable = ['order_id', 'customer_id', 'booking_date', 'time_slot', 'booking_type', 'status'];
    protected $casts    = ['booking_date' => 'date'];

    public function customer()
    {return $this->belongsTo(Customer::class);}
    public function order()
    {return $this->belongsTo(Order::class);}
}

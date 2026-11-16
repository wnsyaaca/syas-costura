<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['customer_id', 'order_id', 'rating', 'review', 'is_approved'];
    protected $casts    = ['is_approved' => 'boolean'];

    public function customer()
    {return $this->belongsTo(Customer::class);}
    public function order()
    {return $this->belongsTo(Order::class);}

    public function scopeApproved($query)
    {return $query->where('is_approved', true);}
}

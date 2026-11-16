<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['user_id', 'phone', 'address'];

    public function user() { return $this->belongsTo(User::class); }
    public function sizes() { return $this->hasMany(Size::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function bookings() { return $this->hasMany(StoreBooking::class); }
    public function testimonials() { return $this->hasMany(Testimonial::class); }
}

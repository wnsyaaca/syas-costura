<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'paid_at' => 'datetime',
        'qr_expires_at' => 'datetime',
        'finishing_at' => 'datetime',
        'rev_deadline' => 'datetime',
        'auto_confirmed' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function reminders()
    {
        return $this->hasMany(PaymentReminder::class);
    }

    public function notifications()
    {
        return $this->hasMany(PaymentNotification::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class);
    }

    public function bookings()
    {
        return $this->hasMany(StoreBooking::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function queue()
    {
        return $this->hasOne(OrderQueue::class);
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }

    // Relasi baru untuk banyak produk dalam satu pesanan
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

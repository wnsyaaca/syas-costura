<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentReminder extends Model
{
    protected $fillable = ['order_id', 'reminder_type', 'sent_at', 'status'];
    protected $casts    = ['sent_at' => 'datetime'];

    public function order()
    {return $this->belongsTo(Order::class);}
}

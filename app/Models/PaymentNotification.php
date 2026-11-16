<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentNotification extends Model
{
    protected $fillable = ['order_id', 'email_recipient', 'subject', 'message_body', 'sent_at'];
    protected $casts    = ['sent_at' => 'datetime'];

    public function order()
    {return $this->belongsTo(Order::class);}
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderQueue extends Model
{
    protected $table    = 'order_queue';
    protected $fillable = ['order_id', 'priority_level', 'target_completion_date', 'assigned_tailor'];
    protected $casts    = ['target_completion_date' => 'date'];

    public function order()
    {return $this->belongsTo(Order::class);}
}

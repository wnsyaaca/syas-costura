<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = ['material_id', 'order_id', 'used_qty'];

    public function material()
    {return $this->belongsTo(MaterialInventory::class, 'material_id');}
    public function order()
    {return $this->belongsTo(Order::class);}
}

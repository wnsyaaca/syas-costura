<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialInventory extends Model
{
    protected $table    = 'materials_inventory';
    protected $fillable = ['item_name', 'stock_qty', 'unit'];

    public function logs()
    {return $this->hasMany(InventoryLog::class, 'material_id');}
}

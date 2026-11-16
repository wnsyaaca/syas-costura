<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'fabric_need_meter', 'image_path'];

    public function category()
    {return $this->belongsTo(Category::class);}
    public function orders()
    {return $this->hasMany(Order::class);}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'price',
        'rating',
        'cook_time'
    ];

    // 🔗 Menu milik 1 Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 🔗 Menu muncul di banyak order
    public function orderItems()
    {
        return $this->hasMany(Orderitem::class);
    }
}
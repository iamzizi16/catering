<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_id',
        'qty',
        'price'
    ];

    // 🔗 Item milik Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 🔗 Item punya Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_method'
    ];

    // 🔗 Order milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Order punya banyak item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
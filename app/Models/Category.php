<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // 🔗 1 Category punya banyak Menu
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
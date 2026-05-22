<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users with Roles
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kurir Delivery',
            'email' => 'kurir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kurir',
        ]);

        User::create([
            'name' => 'Pelanggan Utama',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 2. Seed Categories
        $makanan = Category::create(['name' => 'Makanan']);
        $minuman = Category::create(['name' => 'Minuman']);
        $snack = Category::create(['name' => 'Snack']);
        $dessert = Category::create(['name' => 'Dessert']);

        // 3. Seed Menus (with the existing images present in storage)
        Menu::create([
            'category_id' => $makanan->id,
            'name' => 'Nasi goreng',
            'description' => 'Nasi goreng biasa yang dijual abang abangan gerobak',
            'image' => 'menus/rdJGmvVAC0K7siWkZOvGI1bZ1AxMmpj1ZIgMctbJ.jpg',
            'price' => 12000,
            'rating' => 4.5,
            'cook_time' => 15,
        ]);

        Menu::create([
            'category_id' => $makanan->id,
            'name' => 'Perkedel Spesial',
            'description' => 'Perkedel kentang disajikan dengan cita rasa yang begitu khas',
            'image' => 'menus/kb1ij9CyxkBswTjOHmm5WlbwEpHdjRDLXPzun6U2.jpg',
            'price' => 8000,
            'rating' => 4.5,
            'cook_time' => 15,
        ]);

        Menu::create([
            'category_id' => $makanan->id,
            'name' => 'Bakwan Jagung',
            'description' => 'Bakwan dengan jagung',
            'image' => 'menus/OqiDVdCCcOfp8VDzZBW7CiBH5fOvPb0TN5uezLM3.jpg',
            'price' => 5000,
            'rating' => 4.5,
            'cook_time' => 15,
        ]);
    }
}

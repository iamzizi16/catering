<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Models\User;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| REDIRECT ROLE
|--------------------------------------------------------------------------
*/

Route::get('/redirect', function () {
    if (auth()->user()->role === 'admin') {
        return redirect('/admin/menu');
    }
    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| USER (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // 🏠 LANDING
    Route::get('/', function () {
        $menus = Menu::all();
        return view('landing', compact('menus'));
    });

    // 🛒 CART
    Route::get('/cart', function () {
        $cart = session('cart', []);
        return view('cart', compact('cart'));
    });

    Route::post('/cart/add/{id}', function ($id) {
        $menu = Menu::findOrFail($id);

        $cart = session()->get('cart', []);

        $cart[$id] = [
            "id" => $menu->id,
            "name" => $menu->name,
            "price" => $menu->price,
            "image" => $menu->image,
            "qty" => ($cart[$id]['qty'] ?? 0) + 1
        ];

        session()->put('cart', $cart);

        return back()->with('success', 'Ditambahkan ke keranjang 🛒');
    });

    Route::post('/cart/remove/{id}', function ($id) {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus ❌');
    });

    // 💳 CHECKOUT VIEW
    Route::get('/checkout', function () {
        $cart = session('cart', []);
        return view('checkout', compact('cart'));
    });

    // 💾 CHECKOUT PROCESS
    Route::post('/checkout', [OrderController::class, 'store']);

});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // 🍔 MENU CRUD
    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/create', [MenuController::class, 'create']);
    Route::post('/menu/store', [MenuController::class, 'store']);
    Route::get('/menu/edit/{id}', [MenuController::class, 'edit']);
    Route::post('/menu/update/{id}', [MenuController::class, 'update']);
    Route::get('/menu/delete/{id}', [MenuController::class, 'destroy']);

    // 📦 ORDER MANAGEMENT
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::get('/orders/{id}/{status}', [OrderController::class, 'updateStatus']);

});
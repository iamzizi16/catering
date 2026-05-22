<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 📋 list semua order
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // 🔍 detail order
    public function show($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 🔄 update status
    public function updateStatus($id, $status)
    {
        $order = Order::findOrFail($id);

        $validStatus = ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];

        if (!in_array($status, $validStatus)) {
            return back()->with('error', 'Status tidak valid');
        }

        $order->status = $status;
        $order->save();

        return back()->with('success', 'Status berhasil diupdate 🚀');
    }

    // 💳 CHECKOUT USER PROCESS
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total_price' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method
        ]);

        foreach ($cart as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'qty' => $item['qty'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');

        return redirect('/')
            ->with('success', 'Pesanan Anda berhasil dibuat dan sedang diproses! 🚀');
    }
}
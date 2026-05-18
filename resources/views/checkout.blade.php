<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 📋 semua order admin
    public function index()
    {
        $orders = Order::latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    // 👁 detail order
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // 🔄 update status
    public function updateStatus($id, $status)
    {
        $order = Order::findOrFail($id);

        $order->status = $status;
        $order->save();

        return back()->with('success', 'Status updated');
    }

    // 💳 CHECKOUT USER
    public function store(Request $request)
    {
        $cart = session('cart', []);

        if(empty($cart)) {
            return back()->with('error', 'Cart kosong');
        }

        $total = 0;

        foreach($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $total,
            'status' => 'pending'
        ]);

        foreach($cart as $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'qty' => $item['qty'],
                'price' => $item['price']
            ]);

        }

        session()->forget('cart');

        return redirect('/')
            ->with('success', 'Pesanan berhasil dibuat 🚀');
    }
}
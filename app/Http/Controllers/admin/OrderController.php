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
}
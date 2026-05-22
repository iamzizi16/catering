<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourierController extends Controller
{
    // 📋 Tampil daftar pengiriman aktif
    public function index()
    {
        $orders = Order::where('status', 'shipping')->latest()->get();
        return view('courier.dashboard', compact('orders'));
    }

    // 💾 Konfirmasi pengiriman dengan bukti foto
    public function deliver(Request $request, $id)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $order = Order::findOrFail($id);

        if ($order->status !== 'shipping') {
            return back()->with('error', 'Pesanan ini tidak dalam proses pengiriman.');
        }

        // Upload bukti foto
        $imagePath = $request->file('proof_image')->store('proofs', 'public');

        // Update status ke 'done' (pesanan sukses otomatis) dan simpan path gambar
        $order->update([
            'status' => 'done',
            'proof_image' => $imagePath
        ]);

        return back()->with('success', 'Pesanan berhasil dikonfirmasi dan telah selesai! 🚀');
    }
}

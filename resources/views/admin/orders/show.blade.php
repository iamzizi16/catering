<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Order #{{ $order->id }} | Admin Catera</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-brand-50 text-brand-900 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-2xl bg-white border border-brand-200/50 rounded-3xl p-8 shadow-premium animate-fade-up">

    <!-- Header & Back Link -->
    <div class="mb-6 pb-6 border-b border-brand-100 flex justify-between items-start">
        <div>
            <a href="/admin/orders" class="text-xs font-bold text-gray-500 hover:text-brand-900 transition flex items-center gap-1.5 mb-2">
                <span>←</span> Kembali ke Order Masuk
            </a>
            <h1 class="text-2xl font-extrabold tracking-tight text-brand-900">
                Invoice Order #{{ $order->id }}
            </h1>
            <p class="text-xs text-gray-500 mt-1">Dibuat pada {{ $order->created_at->format('d M Y - H:i') }} WIB</p>
        </div>

        @php
            $statusClass = match(strtolower($order->status)) {
                'pending' => 'bg-amber-50 border-amber-200 text-amber-700',
                'diproses' => 'bg-blue-50 border-blue-200 text-blue-700',
                'dikirim' => 'bg-purple-50 border-purple-200 text-purple-700',
                'selesai' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                'dibatalkan' => 'bg-rose-50 border-rose-200 text-rose-700',
                default => 'bg-gray-50 border-gray-200 text-gray-700',
            };
        @endphp
        <span class="text-xs font-bold border px-3.5 py-1.5 rounded-full {{ $statusClass }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <!-- Customer info details grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8 bg-brand-50/50 border border-brand-200/40 rounded-2xl p-5">
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Penerima</h3>
            <p class="text-sm font-bold text-brand-900">{{ $order->customer_name }}</p>
            <p class="text-xs text-gray-500 mt-1">No. HP: <span class="font-medium text-brand-900">{{ $order->phone }}</span></p>
        </div>

        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Metode & Tujuan</h3>
            <p class="text-xs text-gray-600 leading-relaxed">{{ $order->address }}</p>
            <div class="mt-2.5">
                <span class="text-[10px] bg-brand-100 text-brand-700 px-2 py-0.5 rounded font-bold uppercase tracking-wider">
                    {{ $order->payment_method ?? 'COD' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Items table -->
    <div class="mb-8">
        <h3 class="font-bold text-base text-brand-900 mb-3">Rincian Hidangan</h3>

        <div class="border border-brand-200/40 rounded-2xl overflow-hidden">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-brand-50 border-b border-brand-200/40 text-xs font-bold uppercase text-gray-500 tracking-wider">
                        <th class="p-4">Menu</th>
                        <th class="p-4 text-center">Porsi</th>
                        <th class="p-4 text-right">Harga</th>
                        <th class="p-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="p-4 font-bold text-brand-900">{{ $item->menu->name ?? 'Menu Dihapus' }}</td>
                        <td class="p-4 text-center font-medium text-gray-600">{{ $item->qty }}</td>
                        <td class="p-4 text-right text-gray-600">Rp{{ number_format($item->price) }}</td>
                        <td class="p-4 text-right font-bold text-brand-900">Rp{{ number_format($item->price * $item->qty) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-brand-50/50 border-t border-brand-200/40">
                        <td colspan="3" class="p-4 text-right font-bold text-brand-900">Total Pembayaran</td>
                        <td class="p-4 text-right font-black text-brand-900 text-base">
                            Rp{{ number_format($order->total_price) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Action panel controls -->
    @if($order->status !== 'selesai' && $order->status !== 'dibatalkan')
    <div class="pt-6 border-t border-brand-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Perbarui Status Pesanan</h4>
            <p class="text-xs text-gray-500 mt-0.5">Ubah status pengiriman untuk mengabari pelanggan.</p>
        </div>

        <div class="flex items-center gap-2">
            @if($order->status === 'pending')
                <a href="/admin/orders/{{ $order->id }}/diproses" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition">
                    Proses Pesanan
                </a>
            @endif

            @if($order->status === 'diproses')
                <a href="/admin/orders/{{ $order->id }}/dikirim" 
                   class="bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition">
                    Kirim Katering
                </a>
            @endif

            @if($order->status === 'dikirim')
                <a href="/admin/orders/{{ $order->id }}/selesai" 
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition">
                    Selesai
                </a>
            @endif

            <a href="/admin/orders/{{ $order->id }}/dibatalkan" 
               onclick="return confirm('Apakah Anda yakin ingin membatalkan order ini?')"
               class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold text-xs px-5 py-2.5 rounded-xl transition">
                Batalkan
            </a>
        </div>
    </div>
    @endif

</div>

</body>
</html>
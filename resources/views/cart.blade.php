<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | Catera</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-brand-50 text-brand-900 min-h-screen">

    <!-- 🌐 NAVBAR -->
    <nav class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-brand-200/40 px-6 py-4 flex justify-between items-center z-40">
        <a href="/" class="flex items-center gap-2">
            <span class="text-2xl">🍽️</span>
            <span class="text-xl font-bold tracking-tight text-brand-900">Catera<span class="text-brand-500">.</span></span>
        </a>

        <a href="/" class="bg-brand-100 hover:bg-brand-200/60 text-brand-700 px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-1">
            <span>←</span> Kembali Belanja
        </a>
    </nav>

    <!-- 🛒 CONTENT -->
    <main class="max-w-4xl mx-auto px-6 py-10">

        <div class="flex items-center gap-2.5 mb-8">
            <span class="text-3xl">🛒</span>
            <h1 class="text-3xl font-extrabold tracking-tight text-brand-900">Keranjang Belanja</h1>
        </div>

        @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <!-- CART ITEMS LIST -->
            <div class="lg:col-span-2 space-y-4">
                @php $total = 0; @endphp
                @foreach($cart as $item)
                @php
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                @endphp

                <div class="bg-white border border-brand-200/50 rounded-2xl p-5 flex gap-4 items-center shadow-premium transition hover:scale-[1.005]">
                    
                    <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}"
                         class="w-20 h-20 object-cover rounded-xl border border-brand-100">

                    <div class="flex-1">
                        <h2 class="font-bold text-base text-brand-900 leading-snug">{{ $item['name'] }}</h2>
                        <p class="text-brand-500 text-sm font-semibold mt-1">Rp{{ number_format($item['price']) }}</p>
                        
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs bg-brand-100 text-brand-700 px-2.5 py-1 rounded-md font-bold">Qty: {{ $item['qty'] }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-3 justify-between h-full">
                        <span class="font-extrabold text-brand-900 text-base">
                            Rp{{ number_format($subtotal) }}
                        </span>

                        <form action="/cart/remove/{{ $item['id'] }}" method="POST">
                            @csrf
                            <button class="text-red-500 hover:text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg text-xs font-semibold transition cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- ORDER SUMMARY CARD -->
            <div class="bg-white border border-brand-200/60 rounded-3xl p-6 shadow-premium lg:sticky lg:top-24">
                <h3 class="font-bold text-lg text-brand-900 mb-4 pb-3 border-b border-brand-100">Ringkasan Pesanan</h3>

                <div class="space-y-3 mb-6 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Total Jenis Menu</span>
                        <span class="font-semibold text-brand-900">{{ count($cart) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Total Porsi</span>
                        @php
                            $totalQty = array_sum(array_column($cart, 'qty'));
                        @endphp
                        <span class="font-semibold text-brand-900">{{ $totalQty }} porsi</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-brand-100 flex justify-between items-baseline mb-6">
                    <span class="text-sm font-semibold text-gray-500">Total Harga</span>
                    <span class="text-2xl font-black text-brand-900">Rp{{ number_format($total) }}</span>
                </div>

                <a href="/checkout"
                   class="block text-center w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3.5 rounded-2xl shadow-md shadow-brand-500/10 hover:shadow-brand-500/25 active:scale-95 transition cursor-pointer">
                    Lanjut ke Checkout 🚀
                </a>
            </div>

        </div>
        @else
        <!-- EMPTY CART STATE -->
        <div class="text-center py-20 bg-white rounded-3xl border border-brand-200/40 shadow-premium animate-fade-up">
            <span class="text-6xl">🍲</span>
            <h2 class="text-xl font-bold text-brand-900 mt-4">Keranjang belanja kosong</h2>
            <p class="text-gray-500 text-sm mt-2 max-w-sm mx-auto">
                Kamu belum menambahkan hidangan apapun ke dalam keranjang belanjamu.
            </p>
            <a href="/"
               class="inline-block mt-6 bg-brand-500 hover:bg-brand-600 text-white font-bold px-6 py-3 rounded-2xl shadow-md shadow-brand-500/10 hover:shadow-brand-500/25 transition">
                Cari Menu Lezat Sekarang
            </a>
        </div>
        @endif

    </main>

</body>
</html>
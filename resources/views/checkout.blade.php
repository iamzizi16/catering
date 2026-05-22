<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Catera</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-brand-50 text-brand-900 min-h-screen">

    <!-- 🌐 NAVBAR -->
    <nav class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-brand-200/40 px-6 py-4 flex justify-between items-center z-40">
        <a href="/" class="flex items-center gap-2">
            <span class="text-2xl">🍽️</span>
            <span class="text-xl font-bold tracking-tight text-brand-900">Catera<span class="text-brand-500">.</span></span>
        </a>

        <a href="/cart" class="bg-brand-100 hover:bg-brand-200/60 text-brand-700 px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-1">
            <span>←</span> Kembali ke Keranjang
        </a>
    </nav>

    <!-- 💳 CHECKOUT CONTENT -->
    <main class="max-w-4xl mx-auto px-6 py-10">

        <div class="flex items-center gap-2.5 mb-8">
            <span class="text-3xl">💳</span>
            <h1 class="text-3xl font-extrabold tracking-tight text-brand-900">Informasi Pengiriman</h1>
        </div>

        @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <!-- FORM DETAIL PENGIRIMAN -->
            <div class="lg:col-span-2 bg-white border border-brand-200/50 rounded-3xl p-6 shadow-premium">
                <h2 class="font-bold text-lg text-brand-900 mb-6 flex items-center gap-2 pb-3 border-b border-brand-100">
                    <span>📍</span> Alamat & Penerima
                </h2>

                <form method="POST" action="/checkout" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Nama Lengkap Penerima</label>
                        <input type="text" name="customer_name" required value="{{ auth()->user()->name }}"
                            placeholder="Ahmad Malik"
                            class="w-full p-3.5 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Nomor Telepon / WhatsApp</label>
                        <input type="tel" name="phone" required placeholder="Contoh: 08123456789"
                            class="w-full p-3.5 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Alamat Pengiriman Lengkap</label>
                        <textarea name="address" required placeholder="Tulis jalan, nomor rumah, RT/RW, dan patokan pengiriman..." rows="4"
                            class="w-full p-3.5 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="border border-brand-200 rounded-2xl p-4 flex items-center gap-3 cursor-pointer hover:bg-brand-50 transition-all select-none">
                                <input type="radio" name="payment_method" value="COD" checked class="text-brand-500 focus:ring-brand-500">
                                <div>
                                    <p class="text-sm font-bold text-brand-900">Bayar di Tempat (COD)</p>
                                    <p class="text-xs text-gray-500">Bayar langsung saat katering sampai</p>
                                </div>
                            </label>

                            <label class="border border-brand-200 rounded-2xl p-4 flex items-center gap-3 cursor-pointer hover:bg-brand-50 transition-all select-none">
                                <input type="radio" name="payment_method" value="Transfer Bank" class="text-brand-500 focus:ring-brand-500">
                                <div>
                                    <p class="text-sm font-bold text-brand-900">Transfer Bank / E-Wallet</p>
                                    <p class="text-xs text-gray-500">Transfer manual setelah pesanan dibuat</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button class="w-full mt-4 bg-brand-500 hover:bg-brand-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-brand-500/10 hover:shadow-brand-500/25 active:scale-[0.99] transition duration-200 cursor-pointer">
                        Konfirmasi & Pesan Sekarang 🚀
                    </button>
                </form>
            </div>

            <!-- ORDER SUMMARY SIDEBAR -->
            <div class="space-y-6">
                <!-- ITEMS PREVIEW -->
                <div class="bg-white border border-brand-200/50 rounded-3xl p-6 shadow-premium">
                    <h3 class="font-bold text-base text-brand-900 mb-4 pb-3 border-b border-brand-100">Item Katering</h3>
                    
                    <div class="divide-y divide-brand-100 max-h-60 overflow-y-auto pr-2 space-y-3">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                        @php
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        @endphp
                        <div class="flex items-center justify-between py-2.5 first:pt-0">
                            <div class="flex flex-col pr-2">
                                <span class="font-bold text-sm text-brand-900 line-clamp-1">{{ $item['name'] }}</span>
                                <span class="text-xs text-gray-500">{{ $item['qty'] }} x Rp{{ number_format($item['price']) }}</span>
                            </div>
                            <span class="font-bold text-sm text-brand-900 whitespace-nowrap">
                                Rp{{ number_format($subtotal) }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                    <div class="pt-4 mt-4 border-t border-brand-100 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-gray-500">Total Tagihan</span>
                        <span class="text-xl font-black text-brand-900">Rp{{ number_format($total) }}</span>
                    </div>
                </div>

                <div class="bg-accent-100 border border-accent-500/10 rounded-2xl p-4 flex gap-3 text-accent-600">
                    <span class="text-xl">🛡️</span>
                    <p class="text-xs leading-normal">
                        Katering Anda diproduksi segar di hari pengiriman dengan standar kebersihan tertinggi.
                    </p>
                </div>
            </div>

        </div>
        @else
        <!-- EMPTY REDIRECT -->
        <div class="text-center py-20 bg-white rounded-3xl border border-brand-200/40">
            <span class="text-5xl">🛒</span>
            <h2 class="text-xl font-bold mt-4">Keranjang belanja kosong</h2>
            <p class="text-gray-500 mt-2">Silakan kembali ke menu untuk memesan.</p>
            <a href="/" class="inline-block mt-6 bg-brand-500 text-white font-bold px-6 py-2.5 rounded-xl">Ke Halaman Utama</a>
        </div>
        @endif

    </main>

</body>
</html>
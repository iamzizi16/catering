<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | CateringApp</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-[#0f0f0f] text-white min-h-screen">

    <!-- 🔥 NAVBAR -->
    <nav class="flex justify-between items-center px-8 py-5 border-b border-white/10 bg-black/30 backdrop-blur-xl sticky top-0 z-50">

        <a href="/" class="text-2xl font-black bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent">
            CateringApp
        </a>

        <a href="/"
            class="px-5 py-2 rounded-xl bg-white/10 hover:bg-orange-500 transition">
            ← Kembali
        </a>

    </nav>

    <!-- 🛒 CONTENT -->
    <section class="max-w-6xl mx-auto px-6 py-10">

        <h1 class="text-4xl font-black mb-8">
            Keranjang Kamu 🛒
        </h1>

        @if(count($cart) > 0)

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- ITEMS -->
            <div class="lg:col-span-2 space-y-5">

                @php $total = 0; @endphp

                @foreach($cart as $item)

                @php
                $subtotal = $item['price'] * $item['qty'];
                $total += $subtotal;
                @endphp

                <div class="bg-white/5 border border-white/10 rounded-3xl p-5 flex gap-5 items-center backdrop-blur-xl">

                    <img src="{{ asset('storage/'.$item['image']) }}"
                        class="w-28 h-28 object-cover rounded-2xl">

                    <div class="flex-1">

                        <h2 class="text-2xl font-bold">
                            {{ $item['name'] }}
                        </h2>

                        <p class="text-orange-400 mt-2 font-semibold">
                            Rp{{ number_format($item['price']) }}
                        </p>

                        <p class="text-gray-400 text-sm mt-1">
                            Qty: {{ $item['qty'] }}
                        </p>

                    </div>

                    <div class="text-right">

                        <p class="font-bold text-xl mb-4">
                            Rp{{ number_format($subtotal) }}
                        </p>

                        <form action="/cart/remove/{{ $item['id'] }}" method="POST">
                            @csrf

                            <button class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl transition">
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>

                @endforeach

            </div>

            <!-- CHECKOUT -->
            <div>

                <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl p-8 sticky top-28 shadow-2xl">

                    <h2 class="text-3xl font-black mb-6">
                        Ringkasan
                    </h2>

                    <div class="flex justify-between mb-3">
                        <span>Total Item</span>
                        <span>{{ count($cart) }}</span>
                    </div>

                    <div class="flex justify-between text-2xl font-black mb-8">
                        <span>Total</span>
                        <span>
                            Rp{{ number_format($total) }}
                        </span>
                    </div>

                    <a href="/checkout"
                        class="block text-center bg-white text-black py-4 rounded-2xl font-bold hover:scale-105 transition">
                        Checkout Sekarang 🚀
                    </a>

                </div>

            </div>

        </div>

        @else

        <!-- EMPTY STATE -->
        <div class="flex flex-col items-center justify-center py-32">

            <div class="text-8xl mb-6">
                🍔
            </div>

            <h2 class="text-4xl font-black mb-4">
                Keranjang Masih Kosong
            </h2>

            <p class="text-gray-400 mb-8 text-center max-w-md">
                Kamu belum menambahkan makanan apapun.
                Yuk pilih menu favorit dulu ✨
            </p>

            <a href="/"
                class="px-8 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 font-bold hover:scale-105 transition">
                Belanja Sekarang
            </a>

        </div>

        @endif

    </section>

</body>
</html>
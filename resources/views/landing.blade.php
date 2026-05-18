<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering App</title>

    @vite('resources/css/app.css')

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeUp {
            animation: fadeUp 0.6s ease forwards;
        }
    </style>
</head>

<body class="bg-gray-950 text-white min-h-screen">

    <!-- 🛒 FLOATING CART -->
    <a href="/cart"
        class="fixed bottom-6 right-6 bg-gradient-to-r from-orange-500 to-red-500 p-4 rounded-full shadow-lg hover:scale-110 transition z-50">
        🛒
    </a>

    <!-- 🔥 NAVBAR -->
    <nav class="flex justify-between items-center px-6 py-4 backdrop-blur-lg bg-white/5 border-b border-white/10 sticky top-0 z-40">

        <h1 class="text-xl font-bold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
            CateringApp
        </h1>

        <div class="flex gap-6 text-sm">
            <a href="#" class="hover:text-orange-400">Home</a>
            <a href="#" class="hover:text-orange-400">Menu</a>
            <a href="#" class="hover:text-orange-400">Order</a>
        </div>

    </nav>

    <!-- 🚀 HERO -->
    <section class="relative py-20 px-6 text-center overflow-hidden">

        <!-- glow -->
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-orange-500/20 to-red-500/20 blur-3xl"></div>

        <h1 class="text-5xl font-bold mb-4 relative z-10">
            Catering Premium
            <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
                Tanpa Ribet
            </span>
        </h1>

        <p class="text-gray-400 mb-8 relative z-10">
            Makanan enak, cepat, dan modern. Tinggal klik, langsung makan 🍔
        </p>

        <div class="relative z-10 max-w-xl mx-auto">
            <input
                type="text"
                placeholder="Cari makanan favorit..."
                class="w-full p-4 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-lg outline-none focus:ring-2 focus:ring-orange-500">
        </div>

    </section>

    <!-- ⏳ LOADING SKELETON -->
    <div id="loading" class="grid md:grid-cols-3 gap-6 px-6 mb-10">
        <div class="h-60 bg-white/10 animate-pulse rounded-2xl"></div>
        <div class="h-60 bg-white/10 animate-pulse rounded-2xl"></div>
        <div class="h-60 bg-white/10 animate-pulse rounded-2xl"></div>
    </div>

    <!-- 🍱 MENU -->
    <section class="grid md:grid-cols-3 gap-6 px-6 pb-20">

        @if($menus->isEmpty())
        <p class="text-center text-gray-400 col-span-3">
            Belum ada menu 😢
        </p>
        @endif

        @foreach($menus as $i => $menu)
        <div class="group animate-fadeUp">

            <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl overflow-hidden hover:scale-[1.03] transition duration-300 hover:shadow-[0_0_30px_rgba(249,115,22,0.3)]">

                <div class="relative overflow-hidden">
                    <img src="{{ asset('storage/'.$menu->image) }}"
                        class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">

                    <span class="absolute top-3 left-3 bg-orange-500 px-3 py-1 text-xs rounded-full">
                        {{ $menu->cook_time }} min
                    </span>
                </div>

                <div class="p-4">

                    <h2 class="font-semibold text-lg">{{ $menu->name }}</h2>

                    <div class="flex items-center text-sm text-gray-400 mb-2">
                        ⭐ {{ $menu->rating ?? 4.5 }}
                    </div>

                    <div class="flex justify-between items-center mt-3">

                        <span class="text-orange-400 font-bold text-lg">
                            Rp{{ number_format($menu->price) }}
                        </span>

                        <form action="/cart/add/{{ $menu->id }}" method="POST">

                            @csrf

                            <button
                                class="bg-gradient-to-r from-orange-500 to-red-500 px-4 py-2 rounded-xl text-sm transition hover:scale-105 active:scale-90">
                                + Cart
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </div>
        @endforeach

    </section>

    <!-- ⚡ SCRIPT -->
    <script>
        function addToCart(btn) {
            btn.innerHTML = "✔";
            btn.classList.add("bg-green-500");

            setTimeout(() => {
                btn.innerHTML = "+ Cart";
                btn.classList.remove("bg-green-500");
            }, 1000);
        }

        window.onload = () => {
            document.getElementById("loading").style.display = "none";
        }
    </script>

</body>

</html>
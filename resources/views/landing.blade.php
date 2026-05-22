<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catera | Katering Premium Tanpa Ribet</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-brand-50 text-brand-900 min-h-screen pb-24">

    <!-- 🔔 FLOATING CART (GOFOOD STYLE) -->
    @php
        $cart = session('cart', []);
        $cartCount = 0;
        $cartTotal = 0;
        foreach($cart as $item) {
            $cartCount += $item['qty'];
            $cartTotal += $item['price'] * $item['qty'];
        }
    @endphp

    @if($cartCount > 0)
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-full max-w-lg px-4 z-50">
        <a href="/cart" class="flex justify-between items-center bg-brand-900 text-white px-5 py-4 rounded-2xl shadow-xl hover:scale-[1.02] transition duration-200">
            <div class="flex items-center gap-3">
                <span class="bg-brand-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg">{{ $cartCount }} Item</span>
                <span class="text-sm font-semibold">Rp{{ number_format($cartTotal) }}</span>
            </div>
            <div class="flex items-center gap-2 text-sm font-bold text-brand-500">
                <span>Lihat Keranjang</span>
                <span>→</span>
            </div>
        </a>
    </div>
    @endif

    <!-- 🌐 TOAST NOTIFICATION -->
    @if(session('success'))
    <div id="toast" class="fixed top-20 right-6 bg-white border border-brand-200/80 text-brand-900 px-5 py-3 rounded-2xl shadow-premium z-50 flex items-center gap-3 animate-fade-up">
        <span class="text-accent-500">✨</span>
        <span class="text-sm font-medium">{{ session('success') }}</span>
        <button onclick="document.getElementById('toast').remove()" class="text-gray-400 hover:text-gray-600 text-xs ml-2 cursor-pointer">×</button>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if(toast) toast.remove();
        }, 3000);
    </script>
    @endif

    <!-- 🏠 HEADER / NAVBAR -->
    <nav class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-brand-200/40 px-6 py-4 flex justify-between items-center z-40">
        <div class="flex items-center gap-2">
            <span class="text-2xl">🍽️</span>
            <h1 class="text-xl font-bold tracking-tight text-brand-900">Catera<span class="text-brand-500">.</span></h1>
        </div>

        <div class="flex items-center gap-5 text-sm">
            <div class="hidden sm:flex flex-col text-right">
                <span class="text-xs text-gray-500">Selamat datang,</span>
                <span class="font-bold text-brand-900">{{ auth()->user()->name }}</span>
            </div>
            
            <div class="h-8 w-px bg-brand-200/60 hidden sm:block"></div>

            @if(auth()->user()->role === 'admin')
                <a href="/admin/menu" class="bg-brand-100 hover:bg-brand-200/80 text-brand-700 px-4 py-2 rounded-xl text-xs font-semibold transition">
                    Dashboard Admin
                </a>
            @endif

            <a href="/logout" class="bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 px-4 py-2 rounded-xl text-xs font-semibold transition">
                Keluar
            </a>
        </div>
    </nav>

    <!-- 🚀 HERO SECTION -->
    <section class="max-w-6xl mx-auto px-6 py-12 text-center">
        <span class="bg-brand-100 text-brand-700 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide">
            Catering Modern #1
        </span>
        <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight mt-4 text-brand-900 leading-tight">
            Makanan lezat & sehat,<br>
            <span class="text-brand-500">diantar langsung ke pintu Anda.</span>
        </h2>
        <p class="text-gray-500 text-base max-w-lg mx-auto mt-3">
            Tinggal pilih menu favorit, bayar di tempat atau transfer, biar kami yang siapkan yang terbaik.
        </p>

        <!-- 🔍 SEARCH BAR -->
        <div class="max-w-lg mx-auto mt-8 relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
            <input
                id="search-input"
                type="text"
                placeholder="Cari nasi goreng, perkedel, dll..."
                class="w-full pl-11 pr-4 py-4 rounded-2xl bg-white border border-brand-200/80 shadow-premium outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500 text-sm transition">
        </div>
    </section>

    <!-- 🏷️ CATEGORY TABS -->
    <section class="max-w-6xl mx-auto px-6 mb-8 flex justify-center gap-3 overflow-x-auto py-2">
        <button onclick="filterCategory('all')" id="tab-all" class="category-tab bg-brand-900 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-premium transition cursor-pointer">
            Semua
        </button>
        <button onclick="filterCategory('Makanan')" id="tab-Makanan" class="category-tab bg-white border border-brand-200/60 text-brand-900 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-brand-100/50 transition cursor-pointer">
            🍔 Makanan
        </button>
        <button onclick="filterCategory('Minuman')" id="tab-Minuman" class="category-tab bg-white border border-brand-200/60 text-brand-900 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-brand-100/50 transition cursor-pointer">
            🥤 Minuman
        </button>
        <button onclick="filterCategory('Snack')" id="tab-Snack" class="category-tab bg-white border border-brand-200/60 text-brand-900 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-brand-100/50 transition cursor-pointer">
            🍿 Snack
        </button>
    </section>

    <!-- 🍱 MENU GRID -->
    <section class="max-w-6xl mx-auto px-6">
        @if($menus->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-brand-200/40">
            <span class="text-4xl">😢</span>
            <p class="text-gray-500 font-medium mt-3">Belum ada menu yang tersedia saat ini.</p>
        </div>
        @else
        <div id="menu-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($menus as $menu)
            <div class="menu-card bg-white border border-brand-200/50 rounded-3xl overflow-hidden shadow-premium hover:scale-[1.01] transition-all duration-300 animate-fade-up"
                 data-name="{{ strtolower($menu->name) }}"
                 data-category="{{ $menu->category->name ?? 'Makanan' }}">

                <div class="relative overflow-hidden h-52">
                    <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}"
                         class="w-full h-full object-cover">
                    
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-brand-900/90 text-white text-xs font-bold px-3 py-1.5 rounded-xl backdrop-blur-md flex items-center gap-1">
                            ⏱️ {{ $menu->cook_time ?? 15 }} mnt
                        </span>
                        <span class="bg-white/95 text-brand-900 text-xs font-extrabold px-3 py-1.5 rounded-xl shadow-sm flex items-center gap-1">
                            ⭐ {{ $menu->rating ?? 4.5 }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <span class="text-xs font-semibold text-brand-500 uppercase tracking-wider">{{ $menu->category->name ?? 'Makanan' }}</span>
                    <h3 class="font-bold text-lg text-brand-900 mt-1 line-clamp-1">{{ $menu->name }}</h3>
                    <p class="text-gray-500 text-sm mt-1 line-clamp-2 h-10">{{ $menu->description ?? 'Tidak ada deskripsi.' }}</p>

                    <div class="flex justify-between items-center mt-5 pt-4 border-t border-brand-100">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400">Harga</span>
                            <span class="text-brand-900 font-extrabold text-lg">
                                Rp{{ number_format($menu->price) }}
                            </span>
                        </div>

                        <form action="/cart/add/{{ $menu->id }}" method="POST">
                            @csrf
                            <button class="bg-brand-500 hover:bg-brand-600 text-white font-bold text-sm px-5 py-2.5 rounded-2xl shadow-md shadow-brand-500/10 hover:shadow-brand-500/25 active:scale-95 transition cursor-pointer">
                                + Tambah
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        <!-- 🚫 SEARCH NO RESULTS STATE -->
        <div id="no-results" class="hidden text-center py-20 bg-white rounded-3xl border border-brand-200/40">
            <span class="text-4xl">🔍</span>
            <p class="text-gray-500 font-medium mt-3">Tidak ada menu yang cocok dengan pencarian Anda.</p>
        </div>
        @endif
    </section>

    <!-- ⚡ REALTIME SEARCH & FILTER SCRIPTS -->
    <script>
        let currentCategory = 'all';

        function filterCategory(category) {
            currentCategory = category;
            
            // Update tabs active state
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.classList.remove('bg-brand-900', 'text-white');
                tab.classList.add('bg-white', 'border', 'border-brand-200/60', 'text-brand-900');
            });
            const activeTab = document.getElementById('tab-' + category);
            if(activeTab) {
                activeTab.classList.remove('bg-white', 'border', 'border-brand-200/60', 'text-brand-900');
                activeTab.classList.add('bg-brand-900', 'text-white');
            }

            applyFilters();
        }

        function applyFilters() {
            const searchVal = document.getElementById('search-input').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.menu-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const cat = card.getAttribute('data-category');

                const matchesSearch = name.includes(searchVal);
                const matchesCategory = (currentCategory === 'all' || cat === currentCategory);

                if (matchesSearch && matchesCategory) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const grid = document.getElementById('menu-grid');
            const noResults = document.getElementById('no-results');

            if (grid && noResults) {
                if (visibleCount === 0) {
                    grid.classList.add('hidden');
                    noResults.classList.remove('hidden');
                } else {
                    grid.classList.remove('hidden');
                    noResults.classList.add('hidden');
                }
            }
        }

        document.getElementById('search-input')?.addEventListener('input', applyFilters);
    </script>

</body>
</html>
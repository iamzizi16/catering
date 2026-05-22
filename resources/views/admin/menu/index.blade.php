<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management | Admin Catera</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-brand-50 text-brand-900 min-h-screen flex">

    <!-- 🌐 TOAST NOTIFICATION -->
    @if(session('success'))
    <div id="toast" class="fixed top-6 right-6 bg-white border border-brand-200/80 text-brand-900 px-5 py-3 rounded-2xl shadow-premium z-50 flex items-center gap-3 animate-fade-up">
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

    <!-- 📦 SIDEBAR -->
    <aside class="w-64 bg-white border-r border-brand-200/40 p-6 flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Logo -->
            <div class="flex items-center gap-2 mb-8 pb-4 border-b border-brand-100">
                <span class="text-2xl">⚙️</span>
                <span class="text-lg font-bold tracking-tight text-brand-900">Admin Catera</span>
            </div>

            <!-- Links -->
            <nav class="space-y-2">
                <a href="/admin/menu" class="flex items-center gap-3 bg-brand-100 text-brand-700 px-4 py-3 rounded-2xl text-sm font-bold transition">
                    <span>🍔</span> Menu Management
                </a>
                <a href="/admin/orders" class="flex items-center gap-3 text-gray-500 hover:text-brand-900 hover:bg-brand-50 px-4 py-3 rounded-2xl text-sm font-semibold transition">
                    <span>📦</span> Order Masuk
                </a>
            </nav>
        </div>

        <!-- Exit back to customer mode -->
        <div class="pt-4 border-t border-brand-100 space-y-2">
            <a href="/" class="flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-brand-900 transition">
                <span>←</span> Mode Pelanggan
            </a>
        </div>
    </aside>

    <!-- 💻 MAIN CONTENT -->
    <main class="flex-1 p-6 sm:p-10 max-h-screen overflow-y-auto">

        <!-- Mobile header -->
        <header class="flex md:hidden justify-between items-center mb-6 pb-4 border-b border-brand-200/40">
            <span class="font-bold text-brand-900">Admin Catera</span>
            <div class="flex gap-4 text-xs font-bold">
                <a href="/admin/menu" class="text-brand-500">Menu</a>
                <a href="/admin/orders" class="text-gray-500">Orders</a>
                <a href="/" class="text-gray-500">Pelanggan</a>
            </div>
        </header>

        <!-- Page Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-brand-900">Kelola Menu</h1>
                <p class="text-gray-500 text-sm mt-1">Tambah, edit, atau hapus hidangan katering.</p>
            </div>

            <a href="/admin/menu/create"
               class="bg-brand-900 hover:bg-brand-900/90 text-white font-bold text-sm px-5 py-3 rounded-2xl shadow-md transition cursor-pointer">
                + Tambah Menu
            </a>
        </div>

        <!-- GRID OF ITEMS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($menus as $menu)
            <div class="bg-white border border-brand-200/50 rounded-3xl overflow-hidden shadow-premium transition hover:scale-[1.005]">
                
                <div class="relative h-44 bg-gray-100">
                    <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}"
                         class="h-full w-full object-cover">
                    <span class="absolute top-3 left-3 bg-brand-900/95 text-white text-xs font-bold px-2.5 py-1 rounded-xl">
                        {{ $menu->category->name ?? 'Makanan' }}
                    </span>
                </div>

                <div class="p-5 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-brand-900 line-clamp-1">{{ $menu->name }}</h3>
                        <p class="text-brand-500 font-extrabold text-sm mt-1">Rp{{ number_format($menu->price) }}</p>
                    </div>

                    <div class="flex gap-2 mt-5 pt-4 border-t border-brand-100">
                        <a href="/admin/menu/edit/{{ $menu->id }}"
                           class="flex-1 text-center bg-brand-100 hover:bg-brand-200 text-brand-700 font-semibold text-xs py-2.5 rounded-xl transition">
                            Edit
                        </a>

                        <a href="/admin/menu/delete/{{ $menu->id }}"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')"
                           class="flex-1 text-center bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-xs py-2.5 rounded-xl transition">
                            Hapus
                        </a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </main>

</body>
</html>
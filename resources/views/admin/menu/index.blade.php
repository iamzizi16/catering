@vite('resources/css/app.css')

<body class="bg-gray-950 text-white min-h-screen flex">

<!-- SIDEBAR -->
<div class="w-64 bg-white/5 backdrop-blur-lg border-r border-white/10 p-6">

    <h1 class="text-xl font-bold mb-8 bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
        Admin Panel
    </h1>

    <div class="space-y-3 text-sm">
        <a href="/admin/menu" class="block hover:text-orange-400">🍔 Menu</a>
        <a href="/admin/orders" class="block hover:text-orange-400">📦 Orders</a>
        <a href="#" class="block hover:text-orange-400">👤 Users</a>
    </div>

</div>

<!-- CONTENT -->
<div class="flex-1 p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Menu Management</h2>

        <a href="/admin/menu/create"
           class="bg-gradient-to-r from-orange-500 to-red-500 px-4 py-2 rounded-xl hover:scale-105 transition">
            + Tambah
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

        @foreach($menus as $menu)
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:scale-[1.02] transition">

            <img src="{{ asset('storage/'.$menu->image) }}"
                 class="h-40 w-full object-cover">

            <div class="p-4">

                <h3 class="font-semibold">{{ $menu->name }}</h3>
                <p class="text-orange-400">Rp{{ number_format($menu->price) }}</p>

                <div class="flex gap-2 mt-3">
                    <a href="/admin/menu/edit/{{ $menu->id }}"
                       class="bg-yellow-500 px-3 py-1 rounded text-sm">
                        Edit
                    </a>

                    <a href="/admin/menu/delete/{{ $menu->id }}"
                       class="bg-red-500 px-3 py-1 rounded text-sm">
                        Hapus
                    </a>
                </div>

            </div>
        </div>
        @endforeach

    </div>

</div>

</body>
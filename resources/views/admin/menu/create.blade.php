@vite('resources/css/app.css')

<body class="bg-gray-950 text-white min-h-screen flex items-center justify-center">

<div class="w-full max-w-lg p-6 rounded-2xl bg-white/10 backdrop-blur-lg border border-white/10 shadow-xl">

    <h1 class="text-2xl font-bold mb-6 text-center">
        Tambah Menu 🍔
    </h1>

    <form action="/admin/menu/store" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- Nama -->
    <div>
        <label class="text-sm text-gray-300">Nama Menu</label>
        <input type="text" name="name"
            class="w-full p-3 rounded-xl bg-white/10 border border-white/10 focus:ring-2 focus:ring-orange-500 outline-none"
            placeholder="Contoh: Nasi Goreng Spesial">
    </div>

    <!-- Harga -->
    <div>
        <label class="text-sm text-gray-300">Harga</label>
        <input type="number" name="price"
            class="w-full p-3 rounded-xl bg-white/10 border border-white/10 focus:ring-2 focus:ring-orange-500 outline-none"
            placeholder="15000">
    </div>

    <!-- Kategori -->
    <div>
        <label class="text-sm text-gray-300">Kategori</label>
        <select name="category_id"
            class="w-full p-3 rounded-xl bg-white/10 border border-white/10 focus:ring-2 focus:ring-orange-500 outline-none">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Deskripsi -->
    <div>
        <label class="text-sm text-gray-300">Deskripsi</label>
        <textarea name="description"
            class="w-full p-3 rounded-xl bg-white/10 border border-white/10 focus:ring-2 focus:ring-orange-500 outline-none"
            placeholder="Deskripsi menu..."></textarea>
    </div>

    <!-- Upload -->
    <div>
        <label class="text-sm text-gray-300">Gambar</label>
        <input type="file" name="image"
            class="w-full text-sm text-gray-300 file:bg-orange-500 file:border-0 file:px-4 file:py-2 file:rounded-lg file:text-white file:cursor-pointer">
    </div>

    <!-- Button -->
    <button class="w-full bg-gradient-to-r from-orange-500 to-red-500 py-3 rounded-xl font-semibold hover:scale-105 transition">
        Simpan 🚀
    </button>

    </form>

</div>

</body>
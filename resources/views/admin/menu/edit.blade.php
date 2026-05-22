<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu | Admin Catera</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-brand-50 text-brand-900 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-lg bg-white border border-brand-200/50 rounded-3xl p-8 shadow-premium animate-fade-up">

    <!-- Header & Back Link -->
    <div class="mb-6">
        <a href="/admin/menu" class="text-xs font-bold text-gray-500 hover:text-brand-900 transition flex items-center gap-1.5 mb-2">
            <span>←</span> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl font-extrabold tracking-tight text-brand-900">
            Edit Menu Katering ✏️
        </h1>
        <p class="text-xs text-gray-500 mt-1">Perbarui informasi hidangan katering Anda.</p>
    </div>

    <!-- Error state -->
    @if ($errors->any())
        <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-xs space-y-1">
            <p class="font-bold">Gagal memperbarui menu:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/menu/update/{{ $menu->id }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Nama -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Nama Menu</label>
            <input type="text" name="name" required value="{{ old('name', $menu->name) }}" placeholder="Contoh: Nasi Goreng Spesial"
                class="w-full p-3 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm">
        </div>

        <!-- Harga & Kategori -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Harga (Rp)</label>
                <input type="number" name="price" required value="{{ old('price', $menu->price) }}" placeholder="Contoh: 15000"
                    class="w-full p-3 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Kategori</label>
                <select name="category_id" required
                    class="w-full p-3 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm cursor-pointer">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $cat->id == $menu->category_id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Deskripsi Singkat</label>
            <textarea name="description" placeholder="Ceritakan kelezatan hidangan ini..." rows="3"
                class="w-full p-3 rounded-2xl bg-brand-50 border border-brand-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition text-sm resize-none">{{ old('description', $menu->description) }}</textarea>
        </div>

        <!-- current image preview and upload -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Foto Hidangan</label>
            <div class="flex items-center gap-4 mb-3">
                <img src="{{ asset('storage/'.$menu->image) }}" alt="Preview" class="w-16 h-16 object-cover rounded-xl border border-brand-200">
                <div class="text-xs text-gray-500 leading-normal">
                    <p class="font-semibold text-brand-900">Gambar Saat Ini</p>
                    <p>Biarkan kosong jika tidak ingin mengubah foto.</p>
                </div>
            </div>
            <div class="border border-dashed border-brand-200/80 rounded-2xl p-4 bg-brand-50 flex items-center justify-between">
                <input type="file" name="image"
                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-900 file:text-white hover:file:bg-brand-900/90 file:cursor-pointer">
            </div>
        </div>

        <!-- Submit Button -->
        <button class="w-full mt-4 bg-brand-500 hover:bg-brand-600 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-brand-500/10 hover:shadow-brand-500/25 active:scale-[0.98] transition cursor-pointer">
            Simpan Perubahan 🚀
        </button>

    </form>

</div>

</body>
</html>

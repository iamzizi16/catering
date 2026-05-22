<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kurir | Catera</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-brand-50 text-brand-900 min-h-screen">

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

    @if(session('error'))
    <div id="toast-error" class="fixed top-6 right-6 bg-white border border-red-200 text-red-600 px-5 py-3 rounded-2xl shadow-premium z-50 flex items-center gap-3 animate-fade-up">
        <span>⚠️</span>
        <span class="text-sm font-medium">{{ session('error') }}</span>
        <button onclick="document.getElementById('toast-error').remove()" class="text-gray-400 hover:text-gray-600 text-xs ml-2 cursor-pointer">×</button>
    </div>
    @endif

    <!-- 🏠 HEADER -->
    <nav class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-brand-200/40 px-6 py-4 flex justify-between items-center z-40">
        <div class="flex items-center gap-2">
            <span class="text-2xl">🚴</span>
            <span class="text-xl font-bold tracking-tight text-brand-900">Kurir Catera<span class="text-brand-500">.</span></span>
        </div>

        <div class="flex items-center gap-4 text-sm">
            <span class="hidden sm:inline text-gray-500">Petugas: <b class="text-brand-900">{{ auth()->user()->name }}</b></span>
            <a href="/logout" class="bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 px-4 py-2 rounded-xl text-xs font-semibold transition">
                Keluar
            </a>
        </div>
    </nav>

    <!-- 📦 ACTIVE SHIPMENTS -->
    <main class="max-w-3xl mx-auto px-6 py-10">
        
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-brand-900">Tugas Pengantaran</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar pesanan katering yang sedang Anda kirimkan ke pembeli.</p>
        </div>

        @if($orders->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-brand-200/40 shadow-premium animate-fade-up">
            <span class="text-5xl">✅</span>
            <h2 class="text-lg font-bold text-brand-900 mt-4">Semua pengiriman selesai</h2>
            <p class="text-gray-500 text-sm mt-1">Tidak ada pesanan aktif yang perlu diantar saat ini.</p>
        </div>
        @else
        <div class="space-y-6">
            @foreach($orders as $order)
            <div class="bg-white border border-brand-200/50 rounded-3xl p-6 shadow-premium space-y-5 transition hover:scale-[1.002] animate-fade-up">
                
                <!-- Destination / Info -->
                <div class="flex justify-between items-start gap-4 pb-4 border-b border-brand-100">
                    <div>
                        <span class="text-[10px] bg-brand-100 text-brand-700 px-2 py-0.5 rounded font-bold uppercase tracking-wider">
                            Order #{{ $order->id }}
                        </span>
                        <h2 class="font-bold text-lg text-brand-900 mt-1">{{ $order->customer_name }}</h2>
                        <p class="text-sm font-semibold text-brand-500 mt-0.5">📞 {{ $order->phone }}</p>
                    </div>

                    <div class="text-right">
                        <span class="text-xs text-gray-400">Total Tagihan</span>
                        <p class="font-extrabold text-brand-900 text-base">Rp{{ number_format($order->total_price) }}</p>
                        <span class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider block">
                            {{ $order->payment_method ?? 'COD' }}
                        </span>
                    </div>
                </div>

                <!-- Address detail -->
                <div class="bg-brand-50/50 border border-brand-200/40 rounded-2xl p-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">📍 Alamat Pengiriman</h3>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $order->address }}</p>
                </div>

                <!-- Proof of delivery submission form -->
                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Unggah Bukti Pengantaran</h3>
                    <form action="/courier/deliver/{{ $order->id }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div class="border border-dashed border-brand-200 rounded-2xl p-4 bg-brand-50/30 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <input type="file" name="proof_image" required accept="image/*"
                                class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-900 file:text-white hover:file:bg-brand-900/90 file:cursor-pointer">
                            
                            <button type="submit" class="w-full sm:w-auto bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition whitespace-nowrap cursor-pointer">
                                Konfirmasi Sampai ✔
                            </button>
                        </div>
                    </form>
                </div>

            </div>
            @endforeach
        </div>
        @endif

    </main>

</body>
</html>

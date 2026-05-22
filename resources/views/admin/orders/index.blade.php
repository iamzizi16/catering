<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Masuk | Admin Catera</title>
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
                <a href="/admin/menu" class="flex items-center gap-3 text-gray-500 hover:text-brand-900 hover:bg-brand-50 px-4 py-3 rounded-2xl text-sm font-semibold transition">
                    <span>🍔</span> Menu Management
                </a>
                <a href="/admin/orders" class="flex items-center gap-3 bg-brand-100 text-brand-700 px-4 py-3 rounded-2xl text-sm font-bold transition">
                    <span>📦</span> Order Masuk
                </a>
            </nav>
        </div>

        <!-- Exit back to customer mode -->
        <div class="pt-4 border-t border-brand-100">
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
                <a href="/admin/menu" class="text-gray-500">Menu</a>
                <a href="/admin/orders" class="text-brand-500">Orders</a>
                <a href="/" class="text-gray-500">Pelanggan</a>
            </div>
        </header>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-brand-900">Pesanan Masuk</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau status pengiriman dan pembayaran katering.</p>
        </div>

        <!-- ORDERS LIST -->
        @if($orders->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-brand-200/40 shadow-premium">
            <span class="text-4xl">📦</span>
            <p class="text-gray-500 font-medium mt-3">Belum ada pesanan masuk saat ini.</p>
        </div>
        @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white border border-brand-200/50 rounded-3xl p-6 shadow-premium flex flex-col md:flex-row md:items-center justify-between gap-4 transition hover:scale-[1.002]">
                
                <!-- Customer info -->
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h2 class="font-bold text-base text-brand-900">{{ $order->customer_name }}</h2>
                        <span class="text-xs text-gray-400">Order #{{ $order->id }}</span>
                    </div>
                    <p class="text-xs text-gray-500">No. HP: <span class="font-medium text-brand-900">{{ $order->phone }}</span></p>
                    <p class="text-xs text-gray-500 line-clamp-1 max-w-sm">Tujuan: {{ $order->address }}</p>
                </div>

                <!-- Price and Payment info -->
                <div>
                    <span class="text-xs text-gray-400">Total Pembayaran</span>
                    <p class="font-extrabold text-brand-900 text-base">Rp{{ number_format($order->total_price) }}</p>
                    <span class="text-[10px] bg-brand-100 text-brand-700 px-2 py-0.5 rounded font-bold uppercase tracking-wider">
                        {{ $order->payment_method ?? 'COD' }}
                    </span>
                </div>

                <!-- Status Badge -->
                <div>
                    <span class="text-xs text-gray-400 block mb-1">Status</span>
                    @php
                        $statusClass = match(strtolower($order->status)) {
                            'pending' => 'bg-amber-50 border-amber-200 text-amber-700',
                            'diproses' => 'bg-blue-50 border-blue-200 text-blue-700',
                            'dikirim' => 'bg-purple-50 border-purple-200 text-purple-700',
                            'selesai' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                            'dibatalkan' => 'bg-rose-50 border-rose-200 text-rose-700',
                            default => 'bg-gray-50 border-gray-200 text-gray-700',
                        };
                    @endphp
                    <span class="text-xs font-bold border px-3 py-1.5 rounded-full {{ $statusClass }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Actions / Controls -->
                <div class="flex items-center gap-1.5 flex-wrap pt-3 md:pt-0 border-t border-brand-100 md:border-0">
                    <a href="/admin/orders/{{ $order->id }}" 
                       class="text-xs font-bold text-brand-700 hover:bg-brand-100 bg-brand-50 border border-brand-200/60 px-3.5 py-2 rounded-xl transition">
                        Detail
                    </a>

                    @if($order->status !== 'selesai' && $order->status !== 'dibatalkan')
                        <div class="h-6 w-px bg-brand-200/60 mx-1 hidden sm:block"></div>

                        @if($order->status === 'pending')
                            <a href="/admin/orders/{{ $order->id }}/diproses" 
                               class="text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-2 rounded-xl transition">
                                Proses
                            </a>
                        @endif

                        @if($order->status === 'diproses')
                            <a href="/admin/orders/{{ $order->id }}/dikirim" 
                               class="text-xs font-bold bg-purple-600 hover:bg-purple-700 text-white px-3.5 py-2 rounded-xl transition">
                                Kirim
                            </a>
                        @endif

                        @if($order->status === 'dikirim')
                            <a href="/admin/orders/{{ $order->id }}/selesai" 
                               class="text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-2 rounded-xl transition">
                                Selesai
                            </a>
                        @endif

                        <a href="/admin/orders/{{ $order->id }}/dibatalkan" 
                           onclick="return confirm('Apakah Anda yakin ingin membatalkan order ini?')"
                           class="text-xs font-bold bg-rose-50 hover:bg-rose-100 text-rose-600 px-3.5 py-2 rounded-xl transition">
                            Batal
                        </a>
                    @endif
                </div>

            </div>
            @endforeach
        </div>
        @endif

    </main>

</body>
</html>
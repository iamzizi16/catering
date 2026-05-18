@vite('resources/css/app.css')

<body class="bg-gray-900 text-white p-6">

<h1 class="text-2xl mb-6">Order Masuk 📦</h1>

@foreach($orders as $order)
<div class="bg-gray-800 p-4 rounded mb-4">
    <p><b>{{ $order->customer_name }}</b></p>
    <p>Total: Rp{{ number_format($order->total_price) }}</p>
    <p>Status: {{ $order->status }}</p>

    <div class="mt-2 space-x-2">
        <a href="/admin/orders/{{ $order->id }}" class="bg-blue-500 px-3 py-1 rounded">Detail</a>

        <a href="/admin/orders/{{ $order->id }}/diproses" class="bg-yellow-500 px-3 py-1 rounded">Proses</a>
        <a href="/admin/orders/{{ $order->id }}/dikirim" class="bg-purple-500 px-3 py-1 rounded">Kirim</a>
        <a href="/admin/orders/{{ $order->id }}/selesai" class="bg-green-500 px-3 py-1 rounded">Selesai</a>
    </div>
</div>
@endforeach

</body>
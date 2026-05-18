@vite('resources/css/app.css')

<body class="bg-gray-900 text-white p-6">

<h1 class="text-2xl mb-6">Detail Order 🧾</h1>

<div class="bg-gray-800 p-4 rounded">
    <p>Nama: {{ $order->customer_name }}</p>
    <p>Alamat: {{ $order->address }}</p>
    <p>Status: {{ $order->status }}</p>
</div>

<h2 class="mt-6 mb-2">Item:</h2>

@foreach($order->items as $item)
<div class="bg-gray-700 p-3 rounded mb-2">
    <p>{{ $item->menu->name }}</p>
    <p>Qty: {{ $item->qty }}</p>
    <p>Harga: Rp{{ number_format($item->price) }}</p>
</div>
@endforeach

</body>
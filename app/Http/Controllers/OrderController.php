public function orders()
{
    $orders = \App\Models\Order::latest()->get();
    return view('admin.orders.index', compact('orders'));
}
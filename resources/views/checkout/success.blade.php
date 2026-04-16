
@extends('layouts.app')
@section('title', 'Order Confirmed')
@section('content')
<div class="max-w-2xl mx-auto text-center mb-10">
<div class="text-6xl mb-4">🎉</div>
<h1 class="text-3xl font-black text-gray-800 mb-2">Order Confirmed!</h1>
<p class="text-gray-500">
Thank you <strong>{{ $order->name }}</strong>!
Your order has been placed successfully.
</p>
</div>
<div class="max-w-2xl mx-auto">
<!-- Order Info -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
<div>
<p class="text-xs text-gray-400 mb-1">Order ID</p>
<p class="font-bold text-gray-800">#{{ $order->id }}</p>
</div>
<div>
<p class="text-xs text-gray-400 mb-1">Date</p>
<p class="font-bold text-gray-800">
{{ $order->created_at->format('M j, Y') }}
</p>
</div>
<div>

<p class="text-xs text-gray-400 mb-1">Status</p>
<span class="inline-block px-3 py-1 bg-orange-100
text-orange-600 rounded-full text-xs font-medium">
{{ ucfirst($order->status) }}
</span>
</div>
<div>
<p class="text-xs text-gray-400 mb-1">Total</p>
<p class="font-bold text-gray-800">
${{ number_format($order->total_amount, 2) }}
</p>
</div>
</div>
</div>
<!-- Order Items -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6">
<div class="p-6 border-b border-gray-100">
<h2 class="font-semibold text-gray-800">Items Ordered</h2>
</div>
<div class="divide-y divide-gray-100">
@foreach($order->orderItems as $item)
<div class="p-6 flex items-center justify-between">
<div>
<p class="font-medium text-gray-800">
{{ $item->product->name ?? 'Product unavailable' }}
</p>
<p class="text-sm text-gray-400">
x{{ $item->quantity }} x ${{ number_format($item->price, 2) }}
</p>
</div>
<p class="font-bold text-gray-800">
${{ number_format($item->price * $item->quantity, 2) }}
</p>
</div>
@endforeach
</div>
<div class="p-6 border-t border-gray-100 flex justify-between font-bold">
<span>Total</span>
<span>${{ number_format($order->total_amount, 2) }}</span>
</div>
</div>
<!-- Actions -->
<div class="flex items-center justify-center gap-6">
<a href="{{ route('orders.index') }}"
class="bg-blue-600 text-white px-6 py-3 rounded-xl font-medium
hover:bg-blue-700 transition text-sm">
View My Orders
</a>
<a href="{{ route('products.index') }}"
class="text-gray-500 hover:text-gray-700 text-sm transition">
Continue Shopping
</a>
</div>
</div>
@endsection
@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="mb-8">
<h1 class="text-3xl font-black text-gray-900">Checkout</h1>
<p class="text-gray-500 mt-1">Complete your order details below</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Checkout Form -->
<div class="lg:col-span-2">
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
<h2 class="font-bold text-gray-800 mb-6">Your Details</h2>
@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700
px-4 py-3 rounded-lg mb-6 text-sm">

<ul class="list-disc list-inside space-y-1">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<form action="{{ route('checkout.store') }}" method="POST"
class="space-y-5">
@csrf
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">
Full Name
</label>
<input type="text" name="name"
value="{{ old('name', Auth::user()->name) }}"
class="w-full border border-gray-200 rounded-xl px-4 py-3
text-sm focus:outline-none focus:ring-2
focus:ring-blue-500 transition" />
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">
Email Address
</label>
<input type="email" name="email"
value="{{ old('email', Auth::user()->email) }}"
class="w-full border border-gray-200 rounded-xl px-4 py-3
text-sm focus:outline-none focus:ring-2
focus:ring-blue-500 transition" />
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">
Phone Number
</label>
<input type="text" name="phone"
value="{{ old('phone') }}"
class="w-full border border-gray-200 rounded-xl px-4 py-3
text-sm focus:outline-none focus:ring-2
focus:ring-blue-500 transition" />
</div>
<div>
<label class="block text-sm font-medium text-gray-700 mb-1">
Delivery Address
</label>
<textarea name="address" rows="3"
class="w-full border border-gray-200 rounded-xl px-4 py-3
text-sm focus:outline-none focus:ring-2
focus:ring-blue-500 transition">
{{ old('address') }}
</textarea>
</div>
<button type="submit"
class="w-full bg-blue-600 hover:bg-blue-700 text-white
font-bold py-3 rounded-xl text-sm transition">
Place Order
</button>
</form>
</div>
</div>
<!-- Order Summary -->
<div class="lg:col-span-1">
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 sticky top-24">
<h2 class="font-bold text-gray-800 mb-6">Order Summary</h2>
<div class="space-y-4 mb-6">
@foreach($cart as $item)
<div class="flex justify-between text-sm">
<span class="text-gray-600">
{{ $item['name'] }} x{{ $item['quantity'] }}
</span>
<span class="font-medium">
${{ number_format($item['subtotal'], 2) }}
</span>
</div>
@endforeach
</div>
<div class="border-t border-gray-100 pt-4">
<div class="flex justify-between font-bold text-gray-800">
<span>Total</span>
<span>${{ number_format($total, 2) }}</span>
</div>
</div>
</div>
</div>
</div>
@endsection


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Simple Store')</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
<!-- Navbar -->
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
<div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
<a href="{{ route('products.index') }}" class="text-xl font-bold text-gray-800">
Simple Store
</a>
<div class="flex items-center gap-6">
<a href="{{ route('products.index') }}" class="text-sm text-gray-600">
Products
</a>
@auth
<a href="{{ route('orders.index') }}" class="text-sm text-gray-600">
My Orders
</a>
<a href="{{ route('cart.index') }}" class="text-sm text-gray-600">
@php
$cartCount = array_sum(
array_column(session()->get('cart', []), 'quantity')
);
@endphp
Cart
@if($cartCount > 0)
<span class="bg-blue-600 text-white text-xs
rounded-full px-2 py-0.5 ml-1">
{{ $cartCount }}
</span>
@endif
</a>
<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit" class="text-sm text-gray-600">
Logout
</button>
</form>
@else
<a href="{{ route('login') }}" class="text-sm text-gray-600">Login</a>
<a href="{{ route('register') }}"
class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
Register
</a>
@endauth
</div>
</div>
</nav>
<!-- Flash Messages -->
<div class="max-w-6xl mx-auto px-6 w-full">
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700
px-4 py-3 rounded-lg mt-4 text-sm">
{{ session('success') }}
</div>
@endif
@if(session('error'))


<div class="bg-red-50 border border-red-200 text-red-700
px-4 py-3 rounded-lg mt-4 text-sm">
{{ session('error') }}
</div>
@endif
</div>
<!-- Page Content -->
<main class="flex-1 max-w-6xl mx-auto px-6 py-8 w-full">
@yield('content')
</main>
<!-- Footer -->
<footer class="bg-white border-t border-gray-200 mt-auto">
<div class="max-w-6xl mx-auto px-6 py-4 text-center text-sm text-gray-400">
&copy; {{ date('Y') }} Simple Store
</div>
</footer>
</body>
</html>
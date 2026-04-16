
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Panel') - Simple Store Admin</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
<!-- Sidebar -->
<aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full">
<div class="p-6 border-b border-gray-700">
<h1 class="text-xl font-bold">Simple Store</h1>
<p class="text-gray-400 text-sm mt-1">Admin Panel</p>
</div>
<nav class="flex-1 p-4 space-y-1">
<a href="{{ route('admin.dashboard') }}"
class="flex items-center gap-3 px-4 py-3 rounded-lg
text-gray-300 hover:bg-gray-700 transition">
Dashboard
</a>
<a href="{{ route('admin.orders.index') }}"
class="flex items-center gap-3 px-4 py-3 rounded-lg
text-gray-300 hover:bg-gray-700 transition">
Orders
</a>
<a href="{{ route('admin.products.index') }}"
class="flex items-center gap-3 px-4 py-3 rounded-lg
text-gray-300 hover:bg-gray-700 transition">
Products
</a>
<a href="{{ route('admin.categories.index') }}"
class="flex items-center gap-3 px-4 py-3 rounded-lg
text-gray-300 hover:bg-gray-700 transition">
Categories
</a>
</nav>
<div class="p-4 border-t border-gray-700">
<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit"
class="w-full text-left px-4 py-2 text-gray-300
hover:text-white transition">
Logout
</button>
</form>
</div>
</aside>
<!-- Main Content -->
<main class="flex-1 ml-64 p-8">
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700
px-4 py-3 rounded-lg mb-6">
{{ session('success') }}
</div>
@endif
@yield('content')
</main>
</div>
</body>
</html>
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-gray-500 text-sm">Total Products</h2>
        <p class="text-2xl font-bold">{{ $totalProducts }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-gray-500 text-sm">Total Orders</h2>
        <p class="text-2xl font-bold">{{ $totalOrders }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-gray-500 text-sm">Categories</h2>
        <p class="text-2xl font-bold">{{ $totalCategories }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-gray-500 text-sm">Users</h2>
        <p class="text-2xl font-bold">{{ $totalUsers }}</p>
    </div>

</div>

<!-- Latest Orders -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-4">Latest Orders</h2>

    <table class="w-full text-left">
        <thead>
            <tr class="border-b">
                <th class="py-2">ID</th>
                <th class="py-2">Customer</th>
                <th class="py-2">Total</th>
                <th class="py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
                <tr class="border-b">
                    <td class="py-2">{{ $order->id }}</td>
                    <td class="py-2">{{ $order->user->name ?? 'N/A' }}</td>
                    <td class="py-2">{{ number_format($order->total_amount, 2) }}</td>
                    <td class="py-2">{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">
                        No orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
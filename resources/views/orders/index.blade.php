@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div 
    x-data="{
        search: '',
        status: 'all'
    }"
    class="max-w-6xl mx-auto px-4 py-10"
>

    <!-- 📦 Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-black text-gray-800">My Orders</h1>
        <p class="text-gray-500 text-sm">
            {{ $orders->total() }} order{{ $orders->total() !== 1 ? 's' : '' }} placed
        </p>
    </div>

    <!-- 🔍 Search + Filter -->
    <div class="flex flex-col sm:flex-row gap-3 mb-6">

        <!-- Search -->
        <input type="text"
            x-model="search"
            placeholder="Search Order ID..."
            class="px-4 py-2 border rounded-xl w-full sm:w-64 focus:ring-2 focus:ring-blue-400">

        <!-- Status Filters -->
        @php
            $statuses = ['all','pending','processing','shipped','delivered','cancelled'];
        @endphp

        <div class="flex flex-wrap gap-2">
            @foreach($statuses as $s)
            <button 
                @click="status='{{ $s }}'"
                :class="status==='{{ $s }}' 
                    ? 'bg-blue-600 text-white' 
                    : 'bg-gray-100 text-gray-600'"
                class="px-3 py-1 rounded-full text-xs capitalize transition">
                {{ $s }}
            </button>
            @endforeach
        </div>

    </div>

    @if ($orders->isEmpty())

    <!-- 💤 Empty -->
    <div class="text-center py-20 border rounded-xl bg-gray-50">
        <p class="text-gray-400 text-lg mb-4">No orders yet 📦</p>
        <a href="{{ route('products.index') }}"
            class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
            Start Shopping
        </a>
    </div>

    @else

    <!-- 🧾 Table -->
    <div class="overflow-x-auto bg-white rounded-2xl shadow-sm">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Order</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Items</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orders as $order)
                @php $status = strtolower($order->status); @endphp

                <tr 
                    x-data="{ open:false }"
                    x-show="
                        (status === 'all' || status === '{{ $status }}') &&
                        ('{{ $order->id }}'.includes(search))
                    "
                    x-cloak
                    class="border-b hover:bg-gray-50 transition"
                >

                    <!-- Order -->
                    <td class="px-4 py-3 font-semibold text-gray-800">
                        #{{ $order->id }}
                    </td>

                    <!-- Date -->
                    <td class="px-4 py-3 text-gray-500">
                        {{ $order->created_at->format('M d, Y') }}
                    </td>

                    <!-- Status -->
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @switch($status)
                                @case('pending') bg-yellow-100 text-yellow-700 @break
                                @case('processing') bg-blue-100 text-blue-700 @break
                                @case('shipped') bg-purple-100 text-purple-700 @break
                                @case('delivered') bg-green-100 text-green-700 @break
                                @case('cancelled') bg-red-100 text-red-700 @break
                            @endswitch
                        ">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <!-- Items -->
                    <td class="px-4 py-3">
                        {{ $order->orderItems->count() ?? 0 }}
                    </td>

                    <!-- Total -->
                    <td class="px-4 py-3 font-semibold">
                        ₱{{ number_format($order->total_amount, 2) }}
                    </td>

                    <!-- Action -->
                    <td class="px-4 py-3 text-right space-x-2">

                        <button 
                            @click="open=!open"
                            class="text-gray-500 hover:text-black text-xs">
                            Details
                        </button>

                        <a href="{{ route('orders.show', $order) }}"
                            class="text-blue-500 hover:underline text-xs">
                            View →
                        </a>
                    </td>

                </tr>

                <!-- 🔽 Expand Row -->
                <tr x-show="open" x-transition x-cloak>
                    <td colspan="6" class="bg-gray-50 px-6 py-4 text-sm">

                        <div class="space-y-2">
                            @foreach($order->orderItems ?? [] as $item)
                            <div class="flex justify-between">
                                <span>{{ $item->product->name ?? 'Product' }}</span>
                                <span>
                                    x{{ $item->quantity }} • ₱{{ number_format($item->price, 2) }}
                                </span>
                            </div>
                            @endforeach
                        </div>

                    </td>
                </tr>

                @endforeach
            </tbody>

        </table>

    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>

    @endif

</div>

<!-- Prevent flicker -->
<style>
[x-cloak] { display:none !important; }
</style>
@endsection
@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
            ← Back to Orders
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Order Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        <!-- Customer Info -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Customer Details</h2>
            <p><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>

        <!-- Order Status -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4">Order Status</h2>

            <p class="mb-4">
                <strong>Current Status:</strong>
                <span class="px-3 py-1 rounded text-white
                    @if($order->status == 'pending') bg-yellow-500
                    @elseif($order->status == 'processing') bg-blue-500
                    @elseif($order->status == 'completed') bg-green-600
                    @else bg-red-500 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </p>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <select name="status" class="border p-2 rounded w-full mb-3">
                    @foreach(\App\Models\Order::statuses() as $status)
                        <option value="{{ $status }}"
                            {{ $order->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded w-full hover:bg-blue-700">
                    Update Status
                </button>
            </form>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-lg font-semibold mb-4">Order Items</h2>

        <table class="w-full">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="text-left py-2 px-3">Product</th>
                    <th class="text-left py-2 px-3">Price</th>
                    <th class="text-left py-2 px-3">Quantity</th>
                    <th class="text-left py-2 px-3">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->orderItems as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2 px-3">{{ $item->product->name ?? 'Deleted Product' }}</td>
                    <td class="py-2 px-3">₱{{ number_format($item->price, 2) }}</td>
                    <td class="py-2 px-3">{{ $item->quantity }}</td>
                    <td class="py-2 px-3">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-400">No items found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Order Summary -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
        <div class="flex justify-between mb-2 text-lg">
            <span>Total Amount:</span>
            <strong>₱{{ number_format($order->total_amount, 2) }}</strong>
        </div>
    </div>
</div>
@endsection
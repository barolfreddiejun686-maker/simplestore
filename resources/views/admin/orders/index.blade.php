@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<h1 class="text-2xl font-bold mb-6">Orders</h1>

<div class="bg-white p-6 rounded shadow space-y-4">
<table class="w-full w-full text-left">
    <thead class="bg-gray-100 border-b">
        <tr class="border-b">
            <th class="py-3 px-4">ID</th>
            <th class="py-3 px-4">Customer</th>
            <th class="py-3 px-4">Total</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4">Update</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="border-b px-2 py-1 space-y-4">
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name ?? 'N/A' }}</td>
            <td>₱{{ number_format($order->total_amount, 2) }}</td>

            <!-- Current Status -->
            <td>
                <span class="px-2 py-1 rounded text-white space-y-4
                    @if($order->status == 'pending') bg-yellow-500
                    @elseif($order->status == 'processing') bg-blue-500
                    @elseif($order->status == 'completed') bg-green-600
                    @else bg-red-500 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </td>

            <!-- Update Status -->
            <td>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <select name="status" class="border p-1 px-2 py-1 space-y-4">
                        @foreach(\App\Models\Order::statuses() as $status)
                            <option value="{{ $status }}"
                                {{ $order->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <button class="bg-blue-600 text-white px-2 py-1 ml-2 rounded space-y-4">
                        Update
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
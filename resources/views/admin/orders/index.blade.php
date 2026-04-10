@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<h1 class="text-2xl font-bold mb-6">Orders</h1>

<div class="bg-white p-6 rounded shadow">
<table class="w-full">
    <thead>
        <tr class="border-b">
            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Update</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="border-b">
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name ?? 'N/A' }}</td>
            <td>₱{{ number_format($order->total_amount, 2) }}</td>

            <!-- Current Status -->
            <td>
                <span class="px-2 py-1 rounded text-white
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

                    <select name="status" class="border p-1">
                        @foreach(\App\Models\Order::statuses() as $status)
                            <option value="{{ $status }}"
                                {{ $order->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <button class="bg-blue-600 text-white px-2 py-1 ml-2 rounded">
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
{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="order-page">

    {{-- Back nav --}}
    <a href="{{ route('orders.index') }}" class="back-link">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Orders
    </a>

    {{-- Header --}}
    <div class="order-header">
        <div>
            <h1>Order <span class="order-id">#{{ $order->id }}</span></h1>
            <p class="order-meta">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <span class="badge badge--{{ strtolower($order->status) }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="order-layout">

        {{-- Left col: items --}}
        <div class="order-main">
            <div class="card">
                <div class="card-header">
                    <h2>Items Ordered</h2>
                    <span class="item-count">{{ $order->orderItems->count() }} item{{ $order->orderItems->count() !== 1 ? 's' : '' }}</span>
                </div>

                <div class="items-list">
                    @foreach ($order->orderItems as $item)
                    <div class="order-item">
                        <div class="item-image">
                            @if ($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                     alt="{{ $item->product->name }}"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            @endif
                            <div class="img-fallback {{ $item->product?->image ? 'hidden' : '' }}">                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                                </svg>
                            </div>
                        </div>
                        <div class="item-details">
                            <div class="item-name">{{ $item->product->name ?? 'Product unavailable' }}</div>
                            @if ($item->product && $item->product->sku)
                                <div class="item-sku">SKU: {{ $item->product->sku }}</div>
                            @endif
                        </div>
                        <div class="item-qty">
                            <span class="qty-label">Qty</span>
                            <span class="qty-val">{{ $item->quantity }}</span>
                        </div>
                        <div class="item-price-col">
                            <div class="item-unit-price">${{ number_format($item->price, 2) }} each</div>
                            <div class="item-subtotal">${{ number_format($item->price * $item->quantity, 2) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Order totals --}}
                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    @if (isset($order->shipping_amount))
                    <div class="total-row">
                        <span>Shipping</span>
                        <span>${{ number_format($order->shipping_amount, 2) }}</span>
                    </div>
                    @endif
                    @if (isset($order->tax_amount))
                    <div class="total-row">
                        <span>Tax</span>
                        <span>${{ number_format($order->tax_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="total-row total-final">
                        <span>Total</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right col: info --}}
        <div class="order-sidebar">

            {{-- Shipping address --}}
            @if ($order->shipping_address)
            <div class="card">
                <div class="card-header">
                    <h2>Shipping Address</h2>
                </div>
                <div class="address-block">
                    @if (is_array($order->shipping_address))
                        <div>{{ $order->shipping_address['name'] ?? '' }}</div>
                        <div>{{ $order->shipping_address['line1'] ?? '' }}</div>
                        @if (!empty($order->shipping_address['line2']))
                            <div>{{ $order->shipping_address['line2'] }}</div>
                        @endif
                        <div>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zip'] ?? '' }}</div>
                        <div>{{ $order->shipping_address['country'] ?? '' }}</div>
                    @else
                        <div>{{ $order->shipping_address }}</div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Order info --}}
            <div class="card">
                <div class="card-header">
                    <h2>Order Info</h2>
                </div>
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Order ID</span>
                        <span class="info-val mono">#{{ $order->id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="badge badge--{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Placed</span>
                        <span class="info-val">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    @if ($order->updated_at != $order->created_at)
                    <div class="info-row">
                        <span class="info-label">Updated</span>
                        <span class="info-val">{{ $order->updated_at->format('M d, Y') }}</span>
                    </div>
                    @endif
                    @if (isset($order->payment_method))
                    <div class="info-row">
                        <span class="info-label">Payment</span>
                        <span class="info-val">{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>{{-- /sidebar --}}
    </div>{{-- /layout --}}
</div>

<style>
.order-page {
    max-width: 960px;
    margin: 0 auto;
    padding: 32px 24px;
}

/* Back link */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: #6b7280;
    text-decoration: none;
    margin-bottom: 28px;
    transition: color .15s;
}
.back-link:hover { color: #111; }

/* Header */
.order-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 32px;
}

.order-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: #111;
    margin: 0 0 4px;
}

.order-id { font-family: monospace; }

.order-meta {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

/* Layout */
.order-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 24px;
    align-items: start;
}

@media (max-width: 720px) {
    .order-layout { grid-template-columns: 1fr; }
}

/* Card */
.card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f3f4f6;
}

.card-header h2 {
    font-size: 15px;
    font-weight: 600;
    color: #111;
    margin: 0;
}

.item-count {
    font-size: 13px;
    color: #6b7280;
}

/* Items */
.items-list { padding: 0 20px; }

.order-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid #f3f4f6;
}
.order-item:last-child { border-bottom: none; }

.item-image {
    width: 60px;
    height: 60px;
    min-width: 60px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.img-fallback {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #d1d5db;
}

.item-details { flex: 1; min-width: 0; }

.item-name {
    font-size: 14px;
    font-weight: 500;
    color: #111;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.item-sku {
    font-size: 12px;
    color: #9ca3af;
    margin-top: 2px;
    font-family: monospace;
}

.item-qty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    min-width: 40px;
}

.qty-label { font-size: 11px; color: #9ca3af; text-transform: uppercase; }
.qty-val   { font-size: 15px; font-weight: 600; color: #111; }

.item-price-col { text-align: right; min-width: 80px; }

.item-unit-price {
    font-size: 12px;
    color: #9ca3af;
    margin-bottom: 2px;
}

.item-subtotal {
    font-size: 15px;
    font-weight: 600;
    color: #111;
}

/* Totals */
.order-totals {
    padding: 16px 20px;
    border-top: 1px solid #f3f4f6;
    background: #fafafa;
}

.total-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #374151;
    padding: 4px 0;
}

.total-final {
    font-size: 16px;
    font-weight: 600;
    color: #111;
    padding-top: 10px;
    margin-top: 6px;
    border-top: 1px solid #e5e7eb;
}

/* Sidebar cards */
.address-block {
    padding: 16px 20px;
    font-size: 14px;
    color: #374151;
    line-height: 1.7;
}

.info-list { padding: 4px 20px 8px; }

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
    font-size: 14px;
}
.info-row:last-child { border-bottom: none; }

.info-label { color: #6b7280; }
.info-val   { color: #111; font-weight: 500; }
.info-val.mono { font-family: monospace; font-size: 13px; }

/* Status badges */
.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
}

.badge--pending    { background: #fef3c7; color: #92400e; }
.badge--processing { background: #dbeafe; color: #1e40af; }
.badge--shipped    { background: #ede9fe; color: #5b21b6; }
.badge--delivered  { background: #d1fae5; color: #065f46; }
.badge--cancelled  { background: #fee2e2; color: #991b1b; }
</style>
@endsection
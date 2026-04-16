{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="orders-page">

    <div class="page-header">
        <h1>My Orders</h1>
        <p class="header-sub">{{ $orders->total() }} order{{ $orders->total() !== 1 ? 's' : '' }} placed</p>
    </div>

    @if ($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            <h3>No orders yet</h3>
            <p>When you place an order, it will show up here.</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Start Shopping</a>
        </div>
    @else
        <div class="orders-table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td class="order-num">#{{ $order->id }}</td>
                        <td class="order-date">{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="badge badge--{{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="order-items-count">
                            {{ $order->orderItems->count() ?? '—' }}
                            item{{ ($order->orderItems->count() ?? 0) !== 1 ? 's' : '' }}
                        </td>
                        <td class="order-total">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="order-action">
                            <a href="{{ route('orders.show', $order) }}" class="btn-view">
                                View
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
        <div class="pagination-wrap">
            {{ $orders->links() }}
        </div>
        @endif
    @endif

</div>

<style>
.orders-page {
    max-width: 900px;
    margin: 0 auto;
    padding: 40px 24px;
}

.page-header {
    margin-bottom: 32px;
}

.page-header h1 {
    font-size: 26px;
    font-weight: 600;
    color: #111;
    margin: 0 0 4px;
}

.header-sub {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 80px 24px;
    border: 1px dashed #e5e7eb;
    border-radius: 12px;
    background: #fafafa;
}

.empty-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 72px;
    height: 72px;
    background: #f3f4f6;
    border-radius: 50%;
    color: #9ca3af;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 600;
    color: #111;
    margin: 0 0 8px;
}

.empty-state p {
    font-size: 14px;
    color: #6b7280;
    margin: 0 0 24px;
}

.btn-primary {
    display: inline-block;
    padding: 10px 22px;
    background: #111;
    color: #fff;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: background .15s;
}
.btn-primary:hover { background: #333; }

/* Table */
.orders-table-wrap {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.orders-table thead tr {
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.orders-table th {
    padding: 12px 20px;
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.orders-table tbody tr {
    border-bottom: 1px solid #f3f4f6;
    transition: background .1s;
}

.orders-table tbody tr:last-child { border-bottom: none; }
.orders-table tbody tr:hover { background: #f9fafb; }

.orders-table td {
    padding: 16px 20px;
    color: #374151;
    vertical-align: middle;
}

.order-num   { font-weight: 600; color: #111; font-family: monospace; font-size: 13px; }
.order-date  { color: #6b7280; }
.order-total { font-weight: 600; color: #111; }

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

/* View link */
.btn-view {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 13px;
    font-weight: 500;
    color: #111;
    text-decoration: none;
    padding: 6px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    transition: border-color .15s, background .15s;
    white-space: nowrap;
}
.btn-view:hover { background: #f3f4f6; border-color: #d1d5db; }

/* Pagination */
.pagination-wrap {
    margin-top: 24px;
    display: flex;
    justify-content: center;
}
</style>
@endsection
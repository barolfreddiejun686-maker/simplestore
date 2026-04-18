<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background: #f9fafb; padding: 40px;">
<div style="max-width: 600px; margin: 0 auto; background: #fff;
border-radius: 12px; overflow: hidden;">
<div style="background: #2563eb; padding: 32px; text-align: center;">
<h1 style="color: #fff; margin: 0;">Simple Store</h1>
<p style="color: #bfdbfe; margin: 8px 0 0;">Order Confirmed!</p>
</div>
<div style="padding: 32px;">
<p>Hi <strong>{{ $order->name }}</strong>,</p>
<p>Thank you for your purchase! Your order has been received.</p>
<div style="background: #f3f4f6; border-radius: 8px; padding: 16px; margin: 24px 0;">
<p>Order ID: <strong>#{{ $order->id }}</strong></p>
<p>Date: <strong>{{ $order->created_at->format('F j, Y') }}</strong></p>
<p>Total: <strong>${{ number_format($order->total_amount, 2) }}</strong></p>
<p>Status: <strong>{{ ucfirst($order->status) }}</strong></p>
</div>
<table style="width: 100%; border-collapse: collapse;">
<tr style="background: #f9fafb;">
<th style="text-align: left; padding: 8px;">Product</th>
<th style="text-align: left; padding: 8px;">Qty</th>
<th style="text-align: left; padding: 8px;">Price</th>
</tr>
@foreach($order->orderItems as $item)
<tr>
<td style="padding: 8px;">{{ $item->product->name ?? 'N/A' }}</td>
<td style="padding: 8px;">{{ $item->quantity }}</td>
<td style="padding: 8px;">${{ number_format($item->price, 2) }}</td>
</tr>
@endforeach
</table>
</div>
</div>
</body>
</html>
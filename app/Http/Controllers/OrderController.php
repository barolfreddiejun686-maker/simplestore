<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
public function index()
{
$orders = Order::where('user_id', Auth::id())
->latest()
->paginate(10);
return view('orders.index', compact('orders'));
}
public function show(Order $order)
{
// Make sure the order belongs to the logged in user
if ($order->user_id !== Auth::id()) {
abort(403);
}
$order->load('orderItems.product');
return view('orders.show', compact('order'));
}
}
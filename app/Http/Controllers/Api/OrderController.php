<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
public function index()
{
$orders = Order::with('orderItems.product')
->where('user_id', Auth::id())
->latest()
->get();
return response()->json($orders);
}
}
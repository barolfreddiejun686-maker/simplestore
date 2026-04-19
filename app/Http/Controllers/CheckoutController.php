<?php
namespace App\Http\Controllers;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckoutController extends Controller
{
// Show the checkout form
public function index()
{
$cart = session()->get('cart', []);
// Redirect back to cart if it is empty
if (empty($cart)) {
return redirect()->route('cart.index')
->with('error', 'Your cart is empty!');
}
$total = array_sum(array_column($cart, 'subtotal'));
return view('checkout.index', compact('cart', 'total'));
}
// Process the order
public function store(Request $request)
{
$cart = session()->get('cart', []);
if (empty($cart)) {
return redirect()->route('cart.index')
->with('error', 'Your cart is empty!');
}
// Validate the checkout form
$request->validate([
'name' => 'required|string|max:255',
'email' => 'required|email|max:255',
'phone' => 'required|string|max:20',
'address' => 'required|string|max:500',
]);
// Calculate total from cart
$total = array_sum(array_column($cart, 'subtotal'));
// Create the order record
$order = Order::create([
'user_id' => Auth::id(),
'name' => $request->name,
'email' => $request->email,
'phone' => $request->phone,
'address' => $request->address,
'total_amount' => $total,
'status' => 'pending',
]);
// Create order items and decrement stock
foreach ($cart as $productId => $item) {
OrderItem::create([
'order_id' => $order->id,
'product_id' => $productId,
'quantity' => $item['quantity'],
'price' => $item['price'],
]);
// Reduce stock for each product ordered
$product = Product::find($productId);
if ($product) {
$product->decrement('stock', $item['quantity']);
}
}

// Clear the cart from the session
session()->forget('cart');
// Send confirmation email
Mail::to($order->email)->queue(new OrderPlaced($order));
// Redirect to Xendit payment page
return redirect()->route('payment.pay', $order)
->with('success', 'Order placed successfully!');
}
// Show the order confirmation page
public function success(Order $order)
{
// Make sure the order belongs to the logged in user
if ($order->user_id !== Auth::id()) {
abort(403);
}
$order->load('orderItems.product');
return view('checkout.success', compact('order'));
}
public function direct(Request $request, Product $product)
{
    $quantity = $request->quantity ?? 1;

    $request->session()->put('cart', [
        $product->id => [
            'name'     => $product->name,
            'price'    => $product->price,
            'quantity' => $quantity,
            'subtotal' => $product->price * $quantity,
            'image'    => $product->image,
        ]
    ]);
    
    return redirect()->route('checkout.index');
}
}
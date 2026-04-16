<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
class CartController extends Controller
{
// Show the cart page
public function index()
{
$cart = session()->get('cart', []);
$total = array_sum(array_column($cart, 'subtotal'));
return view('cart.index', compact('cart', 'total'));
}
// Add a product to the cart
public function add(Request $request, Product $product)
{
$request->validate([
'quantity' => 'required|integer|min:1',
]);
$cart = session()->get('cart', []);
$quantity = $request->quantity;
// Check if product already in cart
if (isset($cart[$product->id])) {
$quantity += $cart[$product->id]['quantity'];
}
// Validate against available stock
if ($quantity > $product->stock) {
return back()->with('error', 'Not enough stock available!');
}

$cart[$product->id] = [
'name' => $product->name,
'price' => $product->price,
'quantity' => $quantity,
'image' => $product->image,
'subtotal' => $product->price * $quantity,
];
session()->put('cart', $cart);
return back()->with('success', 'Item added to cart!');
}
// Update cart item quantity
public function update(Request $request, $productId)
{
$request->validate([
'quantity' => 'required|integer|min:1',
]);
$cart = session()->get('cart', []);
if (isset($cart[$productId])) {
$cart[$productId]['quantity'] = $request->quantity;
$cart[$productId]['subtotal'] =
$cart[$productId]['price'] * $request->quantity;
session()->put('cart', $cart);
}
return back()->with('success', 'Cart updated!');
}
// Remove one item from the cart
public function remove($productId)
{
$cart = session()->get('cart', []);
unset($cart[$productId]);
session()->put('cart', $cart);
return back()->with('success', 'Item removed from cart!');
}
// Clear the entire cart
public function clear()
{
session()->forget('cart');
return back()->with('success', 'Cart cleared!');
}
}
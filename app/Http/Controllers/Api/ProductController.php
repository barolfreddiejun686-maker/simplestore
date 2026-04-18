<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
class ProductController extends Controller
{
public function index()
{
$products = Product::with('category')
->when(request('search'), function ($query) {
$query->where('name', 'like', '%' . request('search') . '%');
})
->paginate(12);
return response()->json($products);
}
public function show(Product $product)
{
$product->load('category');
return response()->json($product);
}
}
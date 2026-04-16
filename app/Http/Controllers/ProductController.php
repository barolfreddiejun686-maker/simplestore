<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
public function index(Request $request)
{
$categories = Category::all();
$products = Product::with('category')
->when($request->search, function ($query) use ($request) {
$query->where('name', 'like', '%' . $request->search . '%');
})
->when($request->category, function ($query) use ($request) {
$query->where('category_id', $request->category);
})
->paginate(12);
return view('products.index', compact('products', 'categories'));
}
public function show(Product $product)
{
return view('products.show', compact('product'));
}
}
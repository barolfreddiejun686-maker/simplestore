<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProductController extends Controller
{
public function index()
{
$products = Product::with('category')->paginate(10);
return view('admin.products.index', compact('products'));
}
public function create()
{
$categories = Category::all();
return view('admin.products.create', compact('categories'));
}
public function store(Request $request)
{
$request->validate([
'name' => 'required|string|max:255|unique:products',
'category_id' => 'required|exists:categories,id',
'price' => 'required|numeric|min:0',
'stock' => 'required|integer|min:0',
'image' => 'nullable|image|max:2048',
]);
$imagePath = $request->hasFile('image')
? $request->file('image')->store('products', 'public')
: null;
$name = $request->name;
Product::create([
'name' => $name,
'slug' => Str::slug($name),
'category_id' => $request->category_id,
'description' => $request->description,
'price' => $request->price,
'stock' => $request->stock,
'image' => $imagePath,
]);
return redirect()->route('admin.products.index')
->with('success', 'Product created successfully!');
}
public function edit(Product $product)
{
$categories = Category::all();
return view('admin.products.edit', compact('product', 'categories'));
}
public function update(Request $request, Product $product)
{
$request->validate([
'name' => 'required|string|max:255|unique:products,name,' . $product->id,
'category_id' => 'required|exists:categories,id',
'price' => 'required|numeric|min:0',
'stock' => 'required|integer|min:0',
'image' => 'nullable|image|max:2048',
]);
// Handle image update
if ($request->hasFile('image')) {
// Delete old image if it exists
if ($product->image && Storage::disk('public')->exists($product->image)) {
Storage::disk('public')->delete($product->image);
}
$imagePath = $request->file('image')->store('products', 'public');
} else {
$imagePath = $product->image;
}
$product->update([
'name' => $request->name,
'slug' => Str::slug($request->name),
'category_id' => $request->category_id,
'description' => $request->description,
'price' => $request->price,
'stock' => $request->stock,
'image' => $imagePath,
]);
return redirect()->route('admin.products.index')
->with('success', 'Product updated successfully!');
}
public function destroy(Product $product)
{
// Delete image from storage if it exists
if ($product->image && Storage::disk('public')->exists($product->image)) {
Storage::disk('public')->delete($product->image);
}
$product->delete();
return redirect()->route('admin.products.index')
->with('success', 'Product deleted successfully!');
}
}
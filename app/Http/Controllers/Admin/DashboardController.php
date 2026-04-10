<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
class DashboardController extends Controller
{
public function index()
{
$totalOrders = Order::count();
$totalProducts = Product::count();
$totalUsers = User::where('role', 'customer')->count();
$totalCategories = Category::count();
$totalRevenue = Order::where('status', '!=', 'cancelled')
->sum('total_amount');
$ordersByStatus = Order::selectRaw('status, count(*) as count')
->groupBy('status')
->pluck('count', 'status');
$recentOrders = Order::with('user')
->latest()->take(5)->get();
$lowStockProducts = Product::where('stock', '<=', 5)->get();
return view('admin.dashboard', compact(
    'totalOrders', 'totalProducts', 'totalUsers',
    'totalCategories', 'totalRevenue', 'ordersByStatus',
    'recentOrders', 'lowStockProducts'
    ));
}
}
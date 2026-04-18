<?php
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Dashboard redirect based on role

    // Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])
->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])
->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
->name('checkout.success');
Route::post('/checkout/direct/{product}', [CheckoutController::class, 'direct'])
    ->name('checkout.direct');

});
Route::middleware(['auth', 'user'])
->prefix('user')
->name('user')
->group(function () {
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
});

Route::middleware(['auth', 'admin'])
->prefix('admin')
->name('admin.')
->group(function () {

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
->name('dashboard');
// Categories - full resource CRUD
Route::resource('categories', CategoryController::class);
// Products - full resource CRUD
Route::resource('products', AdminProductController::class);
// Orders - view and update status only
Route::get('/orders', [AdminOrderController::class, 'index'])
->name('orders.index');
Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
->name('orders.show');
Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])
->name('orders.update');
});
// Public product routes - no login needed
Route::get('/products', [ProductController::class, 'index'])
->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])
->name('products.show');
// Authenticated customer routes
Route::middleware('auth')->group(function () {
// Cart routes
Route::get('/cart', [CartController::class, 'index'])
->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])
->name('cart.add');
Route::patch('/cart/update/{productId}', [CartController::class, 'update'])
->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])
->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])
->name('cart.clear');
// Order history routes
Route::get('/orders', [OrderController::class, 'index'])
->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])
->name('orders.show');
});
// Temporary email preview - remove before deploying
Route::get('/email-preview', function () {
    $order = \App\Models\Order::with('orderItems.product')->latest()->first();
    return new \App\Mail\OrderPlaced($order);
    });

    // Inside the auth middleware group
Route::get('/payment/{order}', [PaymentController::class, 'pay'])
->name('payment.pay');
Route::get('/payment/{order}/success', [PaymentController::class, 'success'])
->name('payment.success');
Route::get('/payment/{order}/failure', [PaymentController::class, 'failure'])
->name('payment.failure');
require __DIR__.'/auth.php';

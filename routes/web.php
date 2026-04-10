<?php
use App\Http\Controllers\ProductController;
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
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Dashboard redirect based on role

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

require __DIR__.'/auth.php';

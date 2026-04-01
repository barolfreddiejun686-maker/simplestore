<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
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
}); 

use Illuminate\Support\Facades\Auth;
Route::middleware('auth')->group(function () {

// Dashboard redirect based on role
Route::get('/dashboard', function () {
if (Auth::user()->role === 'admin') {
return redirect()->route('admin.dashboard');
}
return redirect()->route('products.index');
})->name('dashboard');
// ... rest of your auth routes
});

Route::middleware(['auth', 'admin'])
->prefix('admin')
->name('admin.')
->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])
->name('dashboard');
// More admin routes will be added in future modules
});

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');
});

require __DIR__.'/auth.php';

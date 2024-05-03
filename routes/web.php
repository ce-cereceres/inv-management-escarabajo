<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarehouseController;
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

/* Products */
// Index
Route::get('/products', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('products.index');

// Create
Route::get('/products/create', [ProductController::class, 'create'])->middleware(['auth', 'verified'])->name('products.create');

// Store
Route::post('/products', [ProductController::class, 'store'])->middleware(['auth', 'verified'])->name('products.store');

// Show
Route::get('/products/{product}', [ProductController::class, 'show'])->middleware(['auth', 'verified'])->name('products.show');

// Edit
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->middleware(['auth', 'verified'])->name('products.edit');

// Update
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware(['auth', 'verified'])->name('products.update');

// Destroy
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware(['auth', 'verified'])->name('products.destroy');


/* Warehouses */
// Index
Route::get('/warehouses', [WarehouseController::class, 'index'])->middleware(['auth', 'verified'])->name('warehouses.index');

// Create
Route::get('/warehouses/create', [WarehouseController::class, 'create'])->middleware(['auth', 'verified'])->name('warehouses.create');

// Store
Route::post('/warehouses', [WarehouseController::class, 'store'])->middleware(['auth', 'verified'])->name('warehouses.store');



require __DIR__.'/auth.php';

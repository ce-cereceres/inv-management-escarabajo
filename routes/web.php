<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* Products */
    // Index
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Create
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // Store
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Show
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Edit
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    // Update
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // Destroy
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


    /* Warehouses */
    // Index
    Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');

    // Create
    Route::get('/warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');

    // Store
    Route::post('/warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');

    // Edit
    Route::get('/warehouses/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');

    // Update
    Route::put('/warehouses/{warehouse}', [WarehouseController::class, 'update'])->name('warehouses.update');

    // Destroy
    Route::delete('/warehouses/{warehouse}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');

    /* Transfers */
    // Index
    Route::get('/transfers', [TransferController::class, 'index'])->name('transfers.index');

    // Create
    Route::get('/transfers/create', [TransferController::class, 'create'])->name('transfers.create');

    // Store
    Route::post('/transfers', [TransferController::class, 'store'])->name('transfers.store');

    // Show
    Route::get('/transfers/{transfer}', [TransferController::class, 'show'])->name('transfers.show');

    // Confirm
    Route::put('/transfers/{transfer}', [TransferController::class, 'confirmTransfer'])->name('transfers.confirm');

    // Destroy
    Route::delete('/transfers/{transfer}', [TransferController::class, 'destroy'])->name('transfers.destroy');
});


require __DIR__.'/auth.php';

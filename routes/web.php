<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('customer-groups')->name('customer_groups.')->group(function () {
        Route::get('/', [CustomerGroupController::class, 'index'])->name('index');
        Route::get('/create', [CustomerGroupController::class, 'create'])->name('create');
        Route::post('/', [CustomerGroupController::class, 'store'])->name('store');
        Route::get('/{customerGroup}/edit', [CustomerGroupController::class, 'edit'])->name('edit');
        Route::put('/{customerGroup}', [CustomerGroupController::class, 'update'])->name('update');
        Route::delete('/{customerGroup}', [CustomerGroupController::class, 'destroy'])->name('destroy');
    });

    Route::resource('order-statuses', OrderStatusController::class);

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index'); // List orders
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create'); // Show create form
        Route::post('/', [OrderController::class, 'store'])->name('orders.store'); // Store order
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show'); // Show single order
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit'); // Show edit form
        Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update'); // Update order
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy'); // Delete order

        Route::put('/update-order-status/{order}', [OrderController::class, 'updateOrderStatus'])->name('orders.update-order-status');
    });

});

require __DIR__.'/auth.php';

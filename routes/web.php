<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/nosotros', [HomeController::class, 'about'])->name('about');

// Dashboard redirige según rol
Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'admin'    => redirect()->route('admin.restaurants.index'),
        'kitchen'  => redirect()->route('kitchen.index'),
        'delivery' => redirect()->route('delivery.index'),
        default    => redirect()->route('orders.restaurants'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil (todos los autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Administrador
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('dishes', DishController::class);
    Route::resource('restaurants', RestaurantController::class);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Cliente
Route::middleware(['auth', 'role:client,admin'])->group(function () {
    Route::get('/pedir', [OrderController::class, 'restaurants'])->name('orders.restaurants');
    Route::get('/pedir/{restaurant}', [OrderController::class, 'menu'])->name('orders.menu');
    Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Cocina
Route::middleware(['auth', 'role:kitchen,admin'])->group(function () {
    Route::get('/cocina', [KitchenController::class, 'index'])->name('kitchen.index');
    Route::patch('/cocina/{order}/estado', [KitchenController::class, 'updateStatus'])->name('kitchen.update-status');
});

// Repartidor
Route::middleware(['auth', 'role:delivery,admin'])->group(function () {
    Route::get('/entregas', [DeliveryController::class, 'index'])->name('delivery.index');
    Route::patch('/entregas/{order}/estado', [DeliveryController::class, 'updateStatus'])->name('delivery.update-status');
});

require __DIR__.'/auth.php';

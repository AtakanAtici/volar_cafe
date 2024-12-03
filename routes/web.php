<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(!auth()->check()){
        return redirect()->route('login.show');
    }

    if(auth()->user()->is_admin == 1){
        return redirect()->route('admin.dashboard');
    }else{
        return redirect()->route('client.select-dealer');
    }
});
Route::post('logout', function () {
    Auth::logout();
    return redirect()->route('login.show')->with('success', 'Başarıyla çıkış yaptınız.');
})->name('logout');

Route::get('register', [AuthController::class, 'register_show'])->name('register.show');
Route::get('login', [AuthController::class, 'login_show'])->name('login.show');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::middleware(['auth'])->group(function () {
    Route::get('select-dealer', [ClientController::class, 'selectDealer'])->name('client.select-dealer');
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'show'])->name('admin.dashboard');
        Route::prefix('dealer')->group(function () {
            Route::Get('list', [DealerController::class, 'list'])->name('dealer.list');
        });
        Route::get('{id}/products', [DealerController::class, 'showProducts'])->name('dealer.products');
        Route::get('products', [ProductController::class, 'allProducts'])->name('products.all');
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
    });
    Route::get('dealer/{id}/products', [ClientController::class, 'showProducts'])->name('client.products');
    Route::post('admin/products/media/{id}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('order.store');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::get('/orders', [DashboardController::class, 'getOrders'])->name('orders.fetch');
    Route::get('users', [UserController::class, 'list'])->name('users.all');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/delete/{id}', [UserController::class, 'delete']   )->name('users.delete');
    Route::get('/drink', [DrinkController::class, 'list'])->name('drink.list');
    Route::post('/drink/store', [DrinkController::class, 'store'])->name('drink.store');
    Route::put('/drink/{id}', [DrinkController::class, 'update'])->name('drink.update');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');

});


<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CartServiceController;
use App\Http\Controllers\ProfileController;
use App\Models\CartProduct;
use App\Models\CartService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





Route::get('/', function () {
    return Inertia::render('Home', [
        'user' => Auth::user(),
    ]);
})->name('home');

Route::controller(ProductController::class)->prefix('products')->group(function() {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
});

Route::prefix('cart')->group(function() {
    Route::get('/', function() {
        return Inertia::render('Cart', [
            'user' => Auth::user(),
        ]);
    })->middleware(['auth', 'verified']);

    Route::prefix('product')->controller(CartProductController::class)->group(function() {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::patch('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::delete('/', 'clear');
    });

    Route::prefix('service')->controller(CartServiceController::class)->group(function() {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::patch('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::delete('/', 'clear');
    });
});

Route::controller(ServiceController::class)->prefix('services')->group(function() {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

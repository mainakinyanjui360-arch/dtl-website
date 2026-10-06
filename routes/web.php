<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Corporate Routes
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/hardware', function () {
    return Inertia::render('Hardware');
})->name('hardware');

Route::get('/services', function () {
    return Inertia::render('Services');
})->name('services');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/shop', function (\Illuminate\Http\Request $request) {
    $categories = \App\Models\Category::orderBy('name')->get();
    
    $products = \App\Models\Product::with(['category', 'images' => function($q) {
        $q->where('is_primary', true);
    }])->where('is_active', true)->latest()->get();

    return Inertia::render('Shop', [
        'initialCategory' => $request->query('category', 'All'),
        'dbCategories' => $categories,
        'dbProducts' => $products
    ]);
})->name('shop');

Route::get('/shop/product/{slug}', function ($slug) {
    $product = \App\Models\Product::with(['category', 'images' => function($q) {
        $q->orderBy('is_primary', 'desc');
    }])->where('slug', $slug)->firstOrFail();

    $relatedProducts = \App\Models\Product::with(['category', 'images' => function($q) {
        $q->where('is_primary', true);
    }])
    ->where('category_id', $product->category_id)
    ->where('id', '!=', $product->id)
    ->where('is_active', true)
    ->inRandomOrder()
    ->take(4)
    ->get();

    return Inertia::render('ProductShow', [
        'product' => $product,
        'relatedProducts' => $relatedProducts
    ]);
})->name('shop.product');

Route::get('/quote', function () {
    return Inertia::render('Quote');
})->name('quote');

// Shop Admin Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/shop/login', [\App\Http\Controllers\AuthController::class, 'create'])->name('login');
    Route::post('/shop/login', [\App\Http\Controllers\AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/shop/logout', [\App\Http\Controllers\AuthController::class, 'destroy'])->name('logout');
    
    Route::prefix('shop/admin')->group(function() {
        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
    });
});
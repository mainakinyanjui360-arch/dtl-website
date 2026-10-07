<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Corporate Routes
Route::get('/', function () {
    return Inertia::render('Home', [
        'hardwareCategories' => \App\Models\ProcurementCard::where('is_active', true)->orderBy('sort_order')->get(),
        'services' => \App\Models\Service::where('is_active', true)->orderBy('sort_order')->take(4)->get()
    ]);
})->name('home');


Route::get('/services', function () {
    return Inertia::render('Services', [
        'services' => \App\Models\Service::where('is_active', true)->orderBy('sort_order')->get()
    ]);
})->name('services');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/projects', function () {
    return Inertia::render('Projects', [
        'projects' => \App\Models\Project::where('is_active', true)->orderBy('sort_order')->get()
    ]);
})->name('projects');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/partners', function () {
    return Inertia::render('Partners');
})->name('partners');

Route::get('/faqs', function () {
    return Inertia::render('Faqs');
})->name('faqs');

Route::post('/quote-requests', [\App\Http\Controllers\QuoteRequestController::class, 'store'])->name('quote-requests.store');
Route::post('/inquiries', [\App\Http\Controllers\InquiryController::class, 'store'])->name('inquiries.store');

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

Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'store'])->name('checkout.store');


// Shop Admin Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/shop/login', [\App\Http\Controllers\AuthController::class, 'create'])->name('login');
    Route::post('/shop/login', [\App\Http\Controllers\AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/shop/logout', [\App\Http\Controllers\AuthController::class, 'destroy'])->name('logout');
    
    Route::prefix('shop/admin')->group(function() {
        Route::get('/taxonomy', function() {
            return Inertia::render('Admin/TaxonomyIndex', [
                'categories' => \App\Models\Category::withCount('products')->orderBy('name')->get(),
                'tags' => \App\Models\Tag::withCount('products')->orderBy('name')->get(),
            ]);
        })->name('admin.taxonomy.index');

        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
        Route::post('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::post('/products/import', [\App\Http\Controllers\Admin\ProductController::class, 'import'])->name('admin.products.import');
        Route::get('/products/template', [\App\Http\Controllers\Admin\ProductController::class, 'template'])->name('admin.products.template');

        Route::get('/procurement-cards', [\App\Http\Controllers\Admin\ProcurementCardController::class, 'index'])->name('admin.procurement-cards.index');
        Route::post('/procurement-cards', [\App\Http\Controllers\Admin\ProcurementCardController::class, 'store'])->name('admin.procurement-cards.store');
        Route::post('/procurement-cards/{procurement_card}', [\App\Http\Controllers\Admin\ProcurementCardController::class, 'update'])->name('admin.procurement-cards.update');
        Route::delete('/procurement-cards/{procurement_card}', [\App\Http\Controllers\Admin\ProcurementCardController::class, 'destroy'])->name('admin.procurement-cards.destroy');
        
        Route::get('/services', [\App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('admin.services.index');
        Route::post('/services', [\App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('admin.services.store');
        Route::post('/services/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/services/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('admin.services.destroy');
        
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
        Route::post('/settings/sync-currency', [\App\Http\Controllers\Admin\SettingController::class, 'syncCurrency'])->name('admin.settings.sync-currency');

        Route::get('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('admin.projects.index');
        Route::post('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('admin.projects.store');
        Route::post('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('admin.projects.update');
        Route::delete('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('admin.projects.destroy');

        Route::get('/quotes', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'index'])->name('admin.quotes.index');
        Route::post('/quotes/{quote}/send', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'send'])->name('admin.quotes.send');
        Route::delete('/quotes/{quote}', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'destroy'])->name('admin.quotes.destroy');

        Route::get('/inquiries', [\App\Http\Controllers\Admin\InquiryController::class, 'index'])->name('admin.inquiries.index');
        Route::post('/inquiries/{inquiry}/reply', [\App\Http\Controllers\Admin\InquiryController::class, 'reply'])->name('admin.inquiries.reply');
        Route::delete('/inquiries/{inquiry}', [\App\Http\Controllers\Admin\InquiryController::class, 'destroy'])->name('admin.inquiries.destroy');

        Route::post('/categories', function(Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name'
            ]);
            \App\Models\Category::create([
                'name' => $validated['name'],
                'slug' => \Illuminate\Support\Str::slug($validated['name'])
            ]);
            return back()->with('success', 'Category created.');
        })->name('admin.categories.store');

        Route::delete('/categories/{category}', function(\App\Models\Category $category) {
            $category->delete();
            return back()->with('success', 'Category deleted.');
        })->name('admin.categories.destroy');

        Route::post('/tags', function(Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:tags,name'
            ]);
            \App\Models\Tag::create([
                'name' => $validated['name'],
                'slug' => \Illuminate\Support\Str::slug($validated['name'])
            ]);
            return back()->with('success', 'Tag created.');
        })->name('admin.tags.store');

        Route::delete('/tags/{tag}', function(\App\Models\Tag $tag) {
            $tag->delete();
            return back()->with('success', 'Tag deleted.');
        })->name('admin.tags.destroy');
    });
});
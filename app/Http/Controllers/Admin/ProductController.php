<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images')->latest()->get();
        return Inertia::render('Admin/ProductsIndex', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = \App\Models\Tag::orderBy('name')->get();
        return Inertia::render('Admin/ProductCreate', [
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:USD,KES',
            'stock' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'images.*' => 'nullable|image|max:10240', // max 10MB per image
            'spec_sheet' => 'nullable|mimes:pdf|max:10240', // max 10MB PDF
        ]);

        $specSheetPath = null;
        if ($request->hasFile('spec_sheet')) {
            $path = $request->file('spec_sheet')->store('specs', 'public');
            $specSheetPath = '/storage/' . $path;
        }

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(5),
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'specifications' => $validated['specifications'],
            'price' => $validated['price'],
            'currency' => $validated['currency'],
            'stock' => $validated['stock'] ?? true,
            'is_active' => true,
            'spec_sheet_path' => $specSheetPath,
        ]);

        if (!empty($validated['tags'])) {
            $product->tags()->attach($validated['tags']);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                
                $product->images()->create([
                    'image_path' => '/storage/' . $path,
                    'is_primary' => $index === 0, // Make the first uploaded image primary
                ]);
            }
        }

        return redirect()->route('admin.products.index');
    }

    public function template()
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=products_import_template.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $columns = ['Name', 'Category', 'Description', 'Price', 'Currency (USD/KES)', 'Stock (1/0)', 'Buy Online (1/0)'];
        
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['Enterprise Server', 'Servers', 'A powerful 2U server.', '5000', 'USD', '1', '0']);
            fputcsv($file, ['Desktop Mouse', 'Accessories', 'Wireless mouse.', '1500', 'KES', '1', '1']);
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $header = fgetcsv($handle);
        $importedCount = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 7) continue;

            $name = trim($row[0]);
            $categoryName = trim($row[1]);
            $description = trim($row[2]);
            $price = floatval($row[3]);
            $currency = strtoupper(trim($row[4])) === 'KES' ? 'KES' : 'USD';
            $stock = (bool) trim($row[5]);
            $allowCheckout = (bool) trim($row[6]);

            if (empty($name)) continue;

            // Find or create category
            $category = \App\Models\Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => \Illuminate\Support\Str::slug($categoryName)]
            );

            \App\Models\Product::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name) . '-' . \Illuminate\Support\Str::random(5),
                'category_id' => $category->id,
                'description' => $description,
                'price' => $price,
                'currency' => $currency,
                'stock' => $stock,
                'allow_checkout' => $allowCheckout,
                'is_active' => true,
            ]);
            $importedCount++;
        }
        
        fclose($handle);

        return back()->with('success', "Imported {$importedCount} products successfully!");
    }

    public function edit(\App\Models\Product $product)
    {
        $product->load(['category', 'tags', 'images']);
        
        return Inertia::render('Admin/ProductEdit', [
            'product' => $product,
            'categories' => \App\Models\Category::orderBy('name')->get(),
            'tags' => \App\Models\Tag::orderBy('name')->get()
        ]);
    }

    public function update(\App\Http\Requests\ProductRequest $request, \App\Models\Product $product)
    {
        $validated = $request->validated();
        
        if ($validated['name'] !== $product->name) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? $product->slug,
            'description' => $validated['description'],
            'specifications' => $validated['specifications'],
            'price' => $validated['price'],
            'currency' => $validated['currency'],
            'stock' => $validated['stock'],
            'allow_checkout' => $validated['allow_checkout'],
            'is_active' => $validated['is_active'],
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
        ]);

        if (isset($validated['tags'])) {
            $product->tags()->sync($validated['tags']);
        } else {
            $product->tags()->detach();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => '/storage/' . $path,
                    'is_primary' => $product->images()->count() === 0 && $index === 0
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(\App\Models\Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}

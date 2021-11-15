<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index() {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::all()->map(function ($product) {
                return [
                    'thumbnail' => $product->images->first(),
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock_count' => (int) $product->stockCount(),
                    'price' => $product->formattedPrice,
                    'slug' => $product->slug,
                    'created' => $product->created_at->diffForHumans(),
                    'categories' => $product->categories,
                    'in_stock' => $product->inStock(),
                ];
            }),
        ]);
    }

    public function create() {
        $categories = Category::with('parentCategory.parentCategory')
        ->whereHas('parentCategory.parentCategory')
        ->get();

        return Inertia::render('Admin/Products/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreProductRequest $request) {
        $validated = $request->validated();

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
        ]);

        Stock::where('product_id', $product->id)->create([
            'quantity' => $validated['quantity'],
            'product_id' => $product->id,
        ]);

        $product->categories()->sync($request->input('categories', []));

        if($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = 'product-' . $product->slug . '-' . uniqid() . '.' . $file->extension(); //Custom Filename
                $fileInfos = Storage::disk('public')->putFileAs('products', $file, $filename);

                $allImagesPathes[]['path'] = $fileInfos;
            }

            $product->images()->createMany($allImagesPathes);
        }


        return redirect()->route('products.edit', $product)
        ->with('message', 'Product Added Successfully.');
    }

    public function edit(Product $product) {
        $categories = Category::with('parentCategory.parentCategory')
        ->whereHas('parentCategory.parentCategory')
        ->get();

        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'quantity' => $product->stocks->first()->quantity,
            'price' => $product->price->amount(),
            'product_categories' => $product->load('categories'),
            'categories' => $categories,
            'existingImages' => $product->images()->get(),
            'in_stock' => $product->inStock(),
        ]);
    }

    public function update(Product $product, UpdateProductRequest $request) {
        $validated = $request->validated();

        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
        ]);

        Stock::where('product_id', $product->id)->update([
            'quantity' => $validated['quantity'],
        ]);

        $product->categories()->sync($request->input('categories', []));

        if($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = 'product-' . $product->slug . '-' . uniqid() . '.' . $file->extension(); //Custom Filename
                $fileInfos = Storage::disk('public')->putFileAs('products', $file, $filename);

                $allImagesPathes[]['path'] = $fileInfos;
            }

            $product->images()->createMany($allImagesPathes);
        }

        return redirect()->back()
        ->with('message', 'Product Updated Successfully.');
    }

    public function destroy(Product $product) {
        if($product->images()) {
            $product->images()->delete();
        }
        $product->delete();
        return redirect()->route('products.index')
        ->with('message', 'Product Deleted Successfully.');
    }
}

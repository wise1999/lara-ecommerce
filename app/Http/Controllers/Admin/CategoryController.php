<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::whereNull('category_id')
            ->with('childCategories.childCategories')
            ->get();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
        ]);
    }

    public function create() {
        $categories = Category::whereNull('category_id')
        ->with('childCategories')
        ->get();

        return Inertia::render('Admin/Categories/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreCategoryRequest $request) {
        $category = Category::create($request->all());

        return redirect()->route('categories.edit', $category)
        ->with('message', 'Category Added Successfully.');
    }

    public function edit(Category $category) {
        $categories = Category::whereNull('category_id')
        ->with('childCategories')
        ->get();

        $category->load('parentCategory');

        return Inertia::render('Admin/Categories/Edit', [
            'categories' => $categories,
            'product_category' => $category,
        ]);
    }

    public function update(StoreCategoryRequest $request, Category $category) {
        $category->update($request->all());

        return redirect()->back()
        ->with('message', 'Category Updated Successfully.');
    }

    public function destroy(Category $category) {
        $category->delete();

        return redirect()->route('categories.index')
        ->with('message', 'Category Deleted Successfully.');
    }
}

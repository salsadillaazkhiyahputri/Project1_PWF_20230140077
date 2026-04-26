<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-category');

        $categories = Category::withCount('products')->latest()->get();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('manage-category');

        return view('category.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-category');

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('category.index')->with('success', 'Category berhasil ditambahkan.');
    }

    public function edit($id)
    {
        Gate::authorize('manage-category');

        $category = Category::findOrFail($id);

        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-category');

        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('category.index')->with('success', 'Category berhasil diupdate.');
    }

    public function destroy($id)
    {
        Gate::authorize('manage-category');

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category berhasil dihapus.');
    }
}
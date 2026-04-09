<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Ubah dari all() menjadi paginate()
        $products = Product::latest()->paginate(10);
        return view('product.index', compact('products'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer',
        'price' => 'required|numeric',
        'user_id' => 'required|exists:users,id',
        'category_id' => 'required|exists:categories,id',
    ]);

    Product::create($validated);

    return redirect()->route('product.index')->with('success', 'Product created successfully.');
}

    public function create()
{
    $users = User::orderBy('name')->get();
    $categories = \App\Models\Category::orderBy('name')->get();

    return view('product.create', compact('users', 'categories'));
}

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function edit(Product $product)
    {
        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}
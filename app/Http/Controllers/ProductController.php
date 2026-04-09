<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Tambahkan ini jika belum ada

class ProductController extends Controller
{
    use AuthorizesRequests; // Tambahkan ini agar bisa memanggil $this->authorize()

    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('product.create', compact('users', 'categories'));
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

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        // ==========================================
        // 1. TAMBAHKAN OTORISASI POLICY (UPDATE)
        // Memeriksa apakah user boleh mengedit produk ini
        // ==========================================
        $this->authorize('update', $product);

        $users = User::orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('name')->get(); // Tambahkan categories agar tidak error saat edit
        return view('product.edit', compact('product', 'users', 'categories'));
    }

    public function update(Request $request, Product $product) // Ubah $id menjadi Product $product
    {
        // ==========================================
        // 2. TAMBAHKAN OTORISASI POLICY (UPDATE)
        // ==========================================
        $this->authorize('update', $product);

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

    public function delete(Product $product) // Ubah $id menjadi Product $product
    {
        // ==========================================
        // 3. TAMBAHKAN OTORISASI POLICY (DELETE)
        // Memeriksa apakah user/admin boleh menghapus
        // ==========================================
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }

    // Tambahkan method ini jika Anda ingin menjalankan instruksi export Gate
    public function export()
    {
        // Cek Gate secara manual di Controller
        if (\Illuminate\Support\Facades\Gate::denies('export-product')) {
            abort(403, 'Hanya Admin yang bisa export data.');
        }

        // Logika export Anda di sini...
        return response()->json(['message' => 'Proses export dimulai...']);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $products = Product::latest()->paginate(10);
        
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $isAdmin = auth()->user()->role === 'admin';
        $users = $isAdmin ? User::orderBy('name')->get() : collect();
        $categories = $isAdmin ? Category::orderBy('name')->get() : collect();

        return view('product.create', compact('users', 'categories', 'isAdmin'));
    }

    public function store(Request $request)
    {
        $isAdmin = auth()->user()->role === 'admin';

        if ($isAdmin) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'category_id' => 'required|exists:categories,id',
            ],[
                'name.required' => 'Nama produk wajib diisi.',
                'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
                'quantity.required' => 'Jumlah (kuantitas) produk wajib diisi.',
                'quantity.integer' => 'Jumlah produk harus berupa angka bulat (tidak boleh desimal).',
                'price.required' => 'Harga produk wajib diisi.',
                'price.numeric' => 'Harga produk harus berupa angka yang valid.',
            ]);
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
            ], [
                'name.required' => 'Nama produk wajib diisi.',
            ]);
            $validated['user_id'] = auth()->id();
            $validated['category_id'] = Category::firstOrCreate(['name' => 'Uncategorized'])->id;
        }

        try {
        Product::create($validated);

        return redirect()
            ->route('product.index')
            ->with('success', 'Product created successfully.');
            
    } catch (QueryException $e) {
        Log::error('Product store database error', [
            'message' => $e->getMessage(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Database error while creating product.');
            
    } catch (\Throwable $e) {
        Log::error('Product store unexpected error', [
            'message' => $e->getMessage(),
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Unexpected error occurred.');
    }
}

    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return view('product.view', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $isAdmin = auth()->user()->role === 'admin';
        $users = $isAdmin ? User::orderBy('name')->get() : collect();
        $categories = $isAdmin ? Category::all() : collect();

        return view('product.edit', compact('product', 'users', 'categories', 'isAdmin'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Minta izin ke Policy
        Gate::authorize('update', $product);

        $isAdmin = auth()->user()->role === 'admin';

        if ($isAdmin) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'user_id' => 'required|exists:users,id',
                'category_id' => 'required|exists:categories,id',
            ], [
                'name.required' => 'Nama produk wajib diisi.',
                'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
                'quantity.required' => 'Jumlah (kuantitas) produk wajib diisi.',
                'quantity.integer' => 'Jumlah produk harus berupa angka bulat (tidak boleh desimal).',
                'price.required' => 'Harga produk wajib diisi.',
                'price.numeric' => 'Harga produk harus berupa angka yang valid.',
            ]);

        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
            ]);
            $validated['user_id'] = $product->user_id;
            $validated['category_id'] = $product->category_id;
        }

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    // Method untuk Delete (jika form Anda mengarah ke route 'product.destroy')
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Minta izin ke Policy
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }

    // Method untuk Delete (jika form Anda mengarah ke route 'product.delete')
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Minta izin ke Policy
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }

    public function export()
    {
        if (Gate::denies('export-product')) {
            abort(403, 'Hanya Admin yang bisa export data.');
        }

        return response()->json(['message' => 'Proses export dimulai...']);
    }
}
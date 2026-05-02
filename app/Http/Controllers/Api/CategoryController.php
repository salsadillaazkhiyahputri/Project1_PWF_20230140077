<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Category::all()
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create($validated);
        return response()->json([
            'message' => 'Kategori berhasil ditambahkan!',
            'data' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Data tidak ada'], 404);
        return response()->json(['data' => $category], 200);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Data tidak ada'], 404);

        $validated = $request->validate(['name' => 'required|string']);
        $category->update($validated);
        return response()->json(['message' => 'Kategori diperbarui', 'data' => $category], 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Data tidak ada'], 404);

        $category->delete();
        return response()->json(['message' => 'Kategori dihapus'], 200);
    }
}
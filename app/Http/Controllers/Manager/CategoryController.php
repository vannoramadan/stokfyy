<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('manager.category.index', compact('categories'));
    }

    public function create()
    {
        return view('manager.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('manager.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // ✅ Tambahkan method untuk edit
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('manager.category.edit', compact('category'));
    }

    // ✅ Tambahkan method untuk update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);

        return redirect()->route('manager.categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('manager.categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}

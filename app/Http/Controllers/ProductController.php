<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
{
    $search = $request->search;
    $category_id = $request->category_id;

    $products = Product::with(['category', 'attributes'])
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->when($category_id, function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        })
        ->latest()
        ->paginate(10);

    $categories = Category::all();

    return view('products.index', compact('products', 'categories'));
}


    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('status', true)->get();
        $attributes = Attribute::where('status', true)->get();
        return view('products.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'attributes' => 'nullable|array',
            'attributes.*.attribute_id' => 'required_with:attributes|exists:attributes,id',
            'attributes.*.value' => 'required_with:attributes.*.attribute_id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['status'] = $request->has('status');

        // Create product
        $product = Product::create($validated);

        // Sync attributes
        if ($request->has('attributes')) {
            $attributes = [];
            foreach ($request->input('attributes') as $attr) {
                if (!empty($attr['attribute_id'])) {
                    $attributes[$attr['attribute_id']] = ['value' => $attr['value']];
                }
            }
            $product->attributes()->sync($attributes);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->get();
        $attributes = Attribute::where('status', true)->get();
        return view('products.edit', compact('product', 'categories', 'attributes'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'attributes' => 'nullable|array',
            'attributes.*.attribute_id' => 'required_with:attributes|exists:attributes,id',
            'attributes.*.value' => 'required_with:attributes.*.attribute_id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['status'] = $request->has('status');

        // Update product
        $product->update($validated);

        // Sync attributes
        $attributes = [];
        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attr) {
                if (!empty($attr['attribute_id'])) {
                    $attributes[$attr['attribute_id']] = ['value' => $attr['value']];
                }
            }
        }
        $product->attributes()->sync($attributes);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Export products to Excel
     */
    public function export()
    {
        return Excel::download(new ProductExport, 'products-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export product template for import
     */
    public function exportTemplate()
    {
        return Excel::download(new ProductExport(true), 'products-template.xlsx');
    }

    /**
     * Import products from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new ProductImport, $request->file('file'));
            return redirect()->route('products.index')->with('success', 'Products imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing products: ' . $e->getMessage());
        }
    }

    public function exportPDF(Request $request)
{
    $query = Product::with('category')
        ->when($request->category_id, function($q) use ($request) {
            $q->where('category_id', $request->category_id);
        })
        ->when($request->stock_status, function($q) use ($request) {
            if ($request->stock_status == 'low') {
                $q->whereColumn('stock', '<', 'min_stock');
            } elseif ($request->stock_status == 'out') {
                $q->where('stock', 0);
            }
        })
        ->orderBy('name');

    $products = $query->get();
    $categories = Category::all();
    
    $pdf = Pdf::loadView('products.pdf', [
        'products' => $products,
        'categories' => $categories,
        'filter' => [
            'category' => $request->category_id ? Category::find($request->category_id)->name : 'Semua',
            'stock_status' => $this->getStockStatusLabel($request->stock_status)
        ]
    ]);

    return $pdf->download('laporan-produk-'.now()->format('YmdHis').'.pdf');
}

    private function getStockStatusLabel($status)
    {
        return match ($status) {
            'low' =>'Stok Rendah',
            'out' => 'Stok Habis',
            default => 'Semua Status'
        };
    }
}
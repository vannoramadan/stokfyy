<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('manager.product.index', compact('products'));
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        return view('manager.product.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('manager.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:products,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);


        $this->productService->createProduct($validated); // atau langsung Product::create($validated);

        return redirect()->route('manager.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        $categories = Category::all();
        return view('manager.product.edit', compact('product', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', Rule::unique('products', 'code')->ignore($id)],
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $this->productService->updateProduct($id, $validated);

        return redirect()->route('manager.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('manager.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

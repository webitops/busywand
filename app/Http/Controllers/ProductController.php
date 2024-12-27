<?php

namespace App\Http\Controllers;

use App\DTOs\ProductDTO;
use App\Http\Resources\Product\MinimalProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a list of products with their variants.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $products = Product::with('variants.options.option')->paginate(10);

        //        dd($products[0]->variants[0]->options[0]->option->name, []);
        return Inertia::render('Products/Index', [
            'products' => MinimalProductResource::collection($products),
        ]);
    }

    /**
     * Show a single product with its variants.
     *
     * @return \Inertia\Response
     */
    public function show(int $id)
    {
        $product = Product::with('variants.options.option')->findOrFail($id);

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Store a new product with variants.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'variants' => 'nullable|array',
            'variants.*.sku' => 'nullable|string|unique:variants,sku',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.stock_quantity' => 'required|integer|min:0',
            'variants.*.options' => 'nullable|array',
        ]);

        $productDTO = ProductDTO::fromRequest($data);
        $product = $this->productService->createProduct($productDTO);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }
}

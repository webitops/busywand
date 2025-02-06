<?php

namespace App\Http\Controllers;

use App\DTOs\ProductDTO;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
     * @return Response
     */
    public function index()
    {
        $products = Product::with(
            'variants.options.option',
            'variants.product',
        )->paginate(50);

        return Inertia::render('Products/Index', [
            'products' => ProductResource::collection($products)
                ->only([
                    'id',
                    'name',
                    'price',
                    'variants_count',
                    'variants',
                ]),
        ]);
    }

    /**
     * Show a single product with its variants.
     *
     * @return Response
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
     * @return RedirectResponse
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

    /**
     * Remove the specified product and its associated variants.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->variants()->delete();
        $product->delete();

        return to_route('products.index');
    }
}

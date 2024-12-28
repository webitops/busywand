<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\DTOs\VariantDTO;
use App\Models\Product;
use App\Models\Variant;

class ProductService
{
    /**
     * Create a product with optional variants.
     */
    public function createProduct(ProductDTO $productDTO): Product
    {
        // Create product
        $product = Product::create([
            'name' => $productDTO->name,
            'sku' => $productDTO->sku,
            'description' => $productDTO->description,
            'price' => $productDTO->price,
        ]);

        // Create variants if provided
        foreach ($productDTO->variants as $variantData) {
            $variantDTO = VariantDTO::fromRequest($variantData);
            $this->createVariant($product, $variantDTO);
        }

        return $product->load('variants');
    }

    /**
     * Create a variant for a product.
     */
    public function createVariant(Product $product, VariantDTO $variantDTO): Variant
    {
        $variant = $product->variants()->create([
            'sku' => $variantDTO->sku ?? $this->generateVariantSku($product, $variantDTO->options),
            'price' => $variantDTO->price,
            'stock_quantity' => $variantDTO->stock_quantity,
        ]);

        // Handle variant options
        foreach ($variantDTO->options as $key => $value) {
            $option = $product->options()->firstOrCreate(['name' => $key]);
            $optionValue = $option->values()->firstOrCreate(['value' => $value]);
            $variant->options()->attach($optionValue->id);
        }

        return $variant;
    }

    /**
     * Generate a SKU for a variant based on product SKU and options.
     */
    protected function generateVariantSku(Product $product, array $options): string
    {
        $optionValues = array_map(fn ($key, $value) => strtoupper($key).'-'.strtoupper($value), array_keys($options), $options);

        return $product->sku.'-'.implode('-', $optionValues);
    }
}

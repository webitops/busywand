<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\DTOs\VariantDT0;
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
            $variantDTO = VariantDT0::fromRequest($variantData);
            $this->createVariant($product, $variantDTO);
        }

        return $product->load('variants');
    }

    /**
     * Create a variant for a product.
     */
    public function createVariant(Product $product, VariantDT0 $variantDTO): Variant
    {
        $variant = $product->variants()->create([
            'sku' => $variantDTO->sku ?? $this->generateVariantSku($product, $variantDTO->attributes),
            'price' => $variantDTO->price,
            'stock_quantity' => $variantDTO->stock_quantity,
        ]);

        // Handle variant attributes
        foreach ($variantDTO->attributes as $key => $value) {
            $attribute = $product->attributes()->firstOrCreate(['name' => $key]);
            $attributeValue = $attribute->values()->firstOrCreate(['value' => $value]);
            $variant->attributes()->attach($attributeValue->id);
        }

        return $variant;
    }

    /**
     * Generate a SKU for a variant based on product SKU and attributes.
     */
    protected function generateVariantSku(Product $product, array $attributes): string
    {
        $attributeValues = array_map(fn ($key, $value) => strtoupper($key).'-'.strtoupper($value), array_keys($attributes), $attributes);

        return $product->sku.'-'.implode('-', $attributeValues);
    }
}

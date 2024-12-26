<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create several products
        $products = [
            [
                'name'        => 'T-Shirt',
                'sku'         => 'TSHIRT123',
                'description' => 'Comfortable cotton T-Shirt',
                'price'       => 20.00,
                'attributes'  => [
                    'Color' => ['Red', 'Blue', 'Green'],
                    'Size'  => ['S', 'M', 'L', 'XL'],
                ],
            ],
            [
                'name'        => 'Sneakers',
                'sku'         => 'SNKR456',
                'description' => 'Stylish sneakers for daily wear',
                'price'       => 50.00,
                'attributes'  => [
                    'Color' => ['Black', 'White'],
                    'Size'  => ['8', '9', '10', '11'],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $this->createProductWithVariants($productData);
        }
    }

    private function createProductWithVariants(array $productData)
    {
        // Create the product
        $product = Product::create([
            'name'        => $productData['name'],
            'sku'         => $productData['sku'],
            'description' => $productData['description'],
            'price'       => $productData['price'],
        ]);

        // Create attributes and their values
        $attributeValueIds = [];
        foreach ($productData['attributes'] as $attributeName => $attributeValues) {
            $attribute = $product->attributes()->create(['name' => $attributeName]);

            foreach ($attributeValues as $value) {
                $attributeValue = $attribute->values()->create(['value' => $value]);
                $attributeValueIds[ $attributeName ][] = $attributeValue->id;
            }
        }

        // Generate all possible combinations of attributes
        $combinations = $this->generateCombinations(array_values($attributeValueIds));

        // Create variants for each combination
        foreach ($combinations as $combination) {
            $variant = $product->variants()->create([
                'price'          => $product->price, // Default price, can be customized for each variant
                'sku' => $product->sku . '-' . strtoupper(substr(uniqid(), -4)),
                'stock_quantity' => rand(10, 100), // Random stock for testing
            ]);

            // Attach attribute values to the variant
            $variant->attributes()->attach($combination);
        }
    }

    private function generateCombinations(array $arrays, $prefix = [])
    {
        if (empty($arrays)) {
            return [$prefix];
        }

        $result = [];
        foreach (array_shift($arrays) as $value) {
            $result = array_merge($result, $this->generateCombinations($arrays, array_merge($prefix, [$value])));
        }
        return $result;
    }
}

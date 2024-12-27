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
                'name' => 'T-Shirt',
                'sku' => 'TSHIRT123',
                'description' => 'Comfortable cotton T-Shirt',
                'price' => 20.00,
                'options' => [
                    'Color' => ['Red', 'Blue', 'Green'],
                    'Size' => ['S', 'M', 'L', 'XL'],
                ],
            ],
            [
                'name' => 'Sneakers',
                'sku' => 'SNKR456',
                'description' => 'Stylish sneakers for daily wear',
                'price' => 50.00,
                'options' => [
                    'Color' => ['Black', 'White'],
                    'Size' => ['8', '9', '10', '11'],
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
            'name' => $productData['name'],
            'sku' => $productData['sku'],
            'description' => $productData['description'],
            'price' => $productData['price'],
        ]);

        // Create options and their values
        $optionValueIds = [];
        foreach ($productData['options'] as $optionName => $optionValues) {
            $option = $product->options()->create(['name' => $optionName]);

            foreach ($optionValues as $value) {
                $optionValue = $option->values()->create(['value' => $value]);
                $optionValueIds[$optionName][] = $optionValue->id;
            }
        }

        // Generate all possible combinations of options
        $combinations = $this->generateCombinations(array_values($optionValueIds));

        // Create variants for each combination
        foreach ($combinations as $combination) {
            $variant = $product->variants()->create([
                'price' => $product->price, // Default price, can be customized for each variant
                'sku' => $product->sku.'-'.strtoupper(substr(uniqid(), -4)),
                'stock_quantity' => rand(10, 100), // Random stock for testing
            ]);

            // Attach option values to the variant
            $variant->options()->attach($combination);
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

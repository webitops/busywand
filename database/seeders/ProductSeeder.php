<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'T-Shirt',
                'sku' => 'TSHIRT123',
                'description' => 'Comfortable cotton T-Shirt',
                'price' => 20.00,
                'categories' => ['Clothing', 'Summer'], // Add categories here
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
                'categories' => ['Footwear'],
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
        $product = Product::create([
            'name' => $productData['name'],
            'sku' => $productData['sku'],
            'description' => $productData['description'],
            'price' => $productData['price'],
        ]);

        // Attach categories
        if (! empty($productData['categories'])) {
            foreach ($productData['categories'] as $catName) {
                $category = Category::firstOrCreate(
                    ['slug' => Str::slug($catName)],
                    ['name' => $catName]
                );
                $product->categories()->attach($category->id);
            }
        }

        // Create options
        $optionValueIds = [];
        foreach ($productData['options'] as $optionName => $optionValues) {
            $option = $product->options()->create(['name' => $optionName]);
            foreach ($optionValues as $value) {
                $optionValue = $option->values()->create(['value' => $value]);
                $optionValueIds[$optionName][] = $optionValue->id;
            }
        }

        // Variants
        $combinations = $this->generateCombinations(array_values($optionValueIds));
        foreach ($combinations as $combination) {
            $variant = $product->variants()->create([
                'price' => $product->price,
                'sku' => $product->sku.'-'.strtoupper(substr(uniqid(), -4)),
                'stock_quantity' => rand(10, 100),
            ]);
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

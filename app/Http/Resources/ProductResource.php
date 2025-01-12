<?php

namespace App\Http\Resources;

use App\Customization\FilterableJsonResource;
use Illuminate\Http\Request;

class ProductResource extends FilterableJsonResource
{
    public function defaultToArray(Request $request, ?array $filterFields = null): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'categories' => fn () => CategoryResource::collection($this->categories)->only(['id', 'name']),
            'variants_count' => fn () => $this->variants->count(),
            'variants' => fn () => VariantResource::collection($this->variants->load('product'))->only(['id', 'sku', 'price', 'product']),
        ];
    }
}

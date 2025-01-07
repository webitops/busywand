<?php

namespace App\Http\Resources;

use App\Traits\HasResourceFilter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    use HasResourceFilter;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request, ?array $filterFields = null): array
    {
        return $this->applyFieldsFilter([
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'categories' => fn () => CategoryResource::collection($this->categories)->only(['id', 'name']),
            'variants_count' => fn () => $this->variants->count(),
            'variants' => fn () => VariantResource::collection($this->variants)->only(['id', 'sku', 'price', 'product']),
        ], $filterFields);
    }
}

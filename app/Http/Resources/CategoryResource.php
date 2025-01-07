<?php

namespace App\Http\Resources;

use App\Traits\HasResourceFilter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    use HasResourceFilter;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request, ?array $onlyFields = null): array
    {
        return $this->applyFieldsFilter([
            'id' => $this->id,
            'name' => $this->name,
            'products' => fn () => ProductResource::collection($this->products)
                ->only(
                    ['id', 'name', 'variants']
                ),
        ], $onlyFields);
    }
}

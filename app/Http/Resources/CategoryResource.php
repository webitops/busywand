<?php

namespace App\Http\Resources;

use App\Customization\FilterableJsonResource;
use Illuminate\Http\Request;

class CategoryResource extends FilterableJsonResource
{
    public function defaultToArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'products' => fn () => ProductResource::collection($this->products)
                ->only(
                    ['id', 'name', 'variants']
                ),
        ];
    }
}

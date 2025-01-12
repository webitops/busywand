<?php

namespace App\Http\Resources;

use App\Customization\FilterableJsonResource;
use Illuminate\Http\Request;

class VariantResource extends FilterableJsonResource
{
    public function defaultToArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'price' => $this->price,
            'product' => fn () => ProductResource::make($this->product)->only(['id', 'name']),
        ];
    }
}

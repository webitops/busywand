<?php

namespace App\Http\Resources;

use App\Customization\FilterableJsonResource;
use Illuminate\Http\Request;

class CustomerResource extends FilterableJsonResource
{
    public function defaultToArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'customer_groups' => fn () => $this->customerGroups,
        ];
    }
}

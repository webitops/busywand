<?php

namespace App\Http\Resources;

use App\Customization\FilterableJsonResource;
use Illuminate\Http\Request;

class UserResource extends FilterableJsonResource
{
    public function defaultToArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}

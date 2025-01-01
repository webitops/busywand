<?php

namespace App\Http\Resources;

use App\Traits\HasResourceFilter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    use HasResourceFilter;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request, ?array $onlyFieldsForCollection = null): array
    {
        return $this->applyFieldsFilter([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ], $onlyFieldsForCollection);
    }
}

<?php

namespace App\DTOs;

class VariantDTO
{
    public function __construct(
        public ?string $sku,
        public ?float $price,
        public int $stock_quantity,
        public array $options = [] // e.g., ['color' => 'red', 'size' => 'M']
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            sku: $data['sku'] ?? null,
            price: $data['price'] ?? null,
            stock_quantity: $data['stock_quantity'],
            options: $data['options'] ?? []
        );
    }
}

<?php

namespace App\DTOs;

class ProductDTO
{
    public function __construct(
        public string $name,
        public string $sku,
        public ?string $description,
        public float $price,
        public array $variants = [] // Optional list of variants
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            sku: $data['sku'],
            description: $data['description'] ?? null,
            price: $data['price'],
            variants: $data['variants'] ?? [] // Optional variants
        );
    }
}

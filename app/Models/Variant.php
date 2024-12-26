<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int product_id
 * @property float $price
 * @property int $stock_quantity
 * @property-read Product $product
 * @property string $sku
 */
class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sku', 'price', 'stock_quantity'];

    protected $casts = [
        'price'          => 'float',
        'stock_quantity' => 'integer',
    ];

    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attributes');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Fallback logic for price
    public function getPriceAttribute($value): float
    {
        // If the variant's price is null, return the product price
        return $value ?? $this->product->price;
    }
}

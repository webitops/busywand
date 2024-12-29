<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $variant_id
 * @property string $name
 * @property string $sku
 * @property int $quantity
 * @property float $unit_price
 * @property float $tax_amount
 * @property float $discount_amount
 * @property float $subtotal
 * @property float $total
 * @property array|null $options
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'variant_id',
        'name',
        'sku',
        'quantity',
        'unit_price',
        'tax_amount',
        'discount_amount',
        'subtotal',
        'total',
        'options',
    ];

    protected $casts = [
        'unit_price' => 'float',
        'tax_amount' => 'float',
        'discount_amount' => 'float',
        'subtotal' => 'float',
        'total' => 'float',
        'options' => 'array',
    ];

    /**
     * Get the order that owns the item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the variant associated with the item.
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}

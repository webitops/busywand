<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Order
 *
 * @property int $id
 * @property string $order_number
 * @property int $customer_id
 * @property int $status_id
 * @property float $subtotal
 * @property float $tax_total
 * @property float $shipping_total
 * @property float $discount_total
 * @property float $total
 * @property array $shipping_address
 * @property array|null $billing_address
 * @property string|null $notes
 * @property string|null $placed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'status_id',
        'subtotal',
        'tax_total',
        'shipping_total',
        'discount_total',
        'total',
        'shipping_address',
        'billing_address',
        'notes',
        'placed_at',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'tax_total' => 'float',
        'shipping_total' => 'float',
        'discount_total' => 'float',
        'total' => 'float',
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'placed_at' => 'datetime',
    ];

    /**
     * Get the customer associated with the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the status of the order.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

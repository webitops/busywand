<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class OrderStatus
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $is_paid
 * @property bool $is_delivered
 * @property bool $is_cancelled
 * @property bool $is_refunded
 * @property int $order_column
 */
class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';

    protected $fillable = [
        'name',
        'description',
        'is_paid',
        'is_delivered',
        'is_cancelled',
        'is_refunded',
        'order_column',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'is_delivered' => 'boolean',
        'is_cancelled' => 'boolean',
        'is_refunded' => 'boolean',
        'order_column' => 'integer',
    ];

    /**
     * Allowed next statuses (many-to-many pivot).
     */
    public function allowedNextStatuses(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'order_status_transitions',
            'from_status_id',
            'to_status_id'
        )->orderBy('order_column');
    }
}

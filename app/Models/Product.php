<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property string|null $description
 * @property float $price
 * @property Collection|Option[] $options
 * @property Collection|Variant[] $variants
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku', 'description', 'price'];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}

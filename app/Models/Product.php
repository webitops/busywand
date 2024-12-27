<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property string|null $description
 * @property float $price
 * @property \Illuminate\Database\Eloquent\Collection|Option[] $options
 * @property \Illuminate\Database\Eloquent\Collection|Variant[] $variants
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku', 'description', 'price'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}

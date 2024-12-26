<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $product_id
 * @property string $name
 */
class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "name",
        "barcode",
        "category_id",
        "price",
        "image",
    ];
    protected $with = ['stock'];
    public static function boot()
    {
        parent::boot();

        static::deleted(function (Product $product) {
            $product->stock()->delete();
        });
    }
    public function stock()
    {
        return $this->hasOne(ProductStock::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function getTotalStockAttribute(){
        return $this->stock_warehouse + $this->stock_store;
    }
}

<?php

namespace App;

use App\Products;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'sale_qty',
        'in_stock',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }
}

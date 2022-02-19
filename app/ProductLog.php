<?php

namespace App;

use App\Products;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    protected $table = "product_log";
    protected $fillable = [
        'name',
        'date',
        'remarks',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }
}

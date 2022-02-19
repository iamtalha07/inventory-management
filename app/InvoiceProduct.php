<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceProduct extends Model
{
    use SoftDeletes;
    protected $table = "invoice_product";

    protected $fillable = [
        'invoice_id',
        'product_id',
        'qty',
        'disc',
        'amount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function product()
    // {
    //     return $this->belongsToMany(Products::class);
    // }
}

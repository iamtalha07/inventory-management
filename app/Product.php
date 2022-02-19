<?php

namespace App;

use App\Stock;
use App\Invoice;
use App\ProductLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'purchase_qty',
        'purchase_rate',
        'sale_rate',
        'date',
        'description',
    ];

    public function ProductLog()
    {
        return $this->hasMany(ProductLog::class,'product_id','id');
    }

    // public function Stock()
    // {
    //     return $this->hasMany(Stock::class,'product_id','id');
    // }

    public function Stock()
    {
        return $this->hasOne(Stock::class,'product_id','id');
    }

    // public function invoice_details()
    // {
    //     return $this->hasMany(InvoiceProduct::class,'product_id','id');
    // }
    public function invoice_details()
    {
        return $this->belongsToMany(Invoice::class,'invoice_product');
    }
}

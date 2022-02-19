<?php

namespace App;

use App\Booker;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected $table = "invoice";
    protected $fillable = [
        'customer_name',
        'booker_name',
        'salesman_name',
        'area_name',
        'status',
        'total',
    ];
    public function booker()
    {
        return $this->belongsTo(Booker::class,'booker_id','id')->withTrashed();
    }

    public function saveProduct()
    {
        return $this->hasMany(InvoiceProduct::class,'invoice_id','id');
    }

    public function invoiceProduct()
    {
        return $this->belongsToMany(Product::class,'invoice_product')->withTrashed()->withPivot('qty','disc','amount');
    }

}

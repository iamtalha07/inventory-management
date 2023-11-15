<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    protected $table = "sales_return";

    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity_returned',
        'reason',
        'return_date'
    ];

}

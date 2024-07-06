<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandBalance extends Model
{
    protected $table = 'brand_balance';

    protected $fillable = [
        'brand_id',
        'last_paid_bill_no',
        'balance',
        'created_at',
        'updated_at',
    ];

}

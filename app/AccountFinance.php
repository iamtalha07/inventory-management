<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountFinance extends Model
{
    use SoftDeletes;
    protected $table = "account_finance";
    
    protected $fillable = [
    'brand_id',
    'bill_no',
    'product_name',
    'bill_date',
    'total_amount',
    'amount_paid',
    'amount_remaining',
    'payable_by',
    'payable_to',
    'remarks',
    'created_at',
    'updated_at',
    ];
}

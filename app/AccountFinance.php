<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountFinance extends Model
{
    use SoftDeletes;
    protected $table = "account_finance";
    
    protected $guarded = [];
}

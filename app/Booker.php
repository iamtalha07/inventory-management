<?php

namespace App;

use App\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booker extends Model
{
    use SoftDeletes;
    protected $table = "bookers";

    // public function invoice()
    // {
    //     return $this->hasMany(Invoice::class,'booker_id','id');
    // }
    public function invoice()
    {
        return $this->hasMany(Invoice::class,'booker_id','id');
    }
}

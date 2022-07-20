<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
    ];

    public function Product()
    {
        return $this->hasMany(Product::class,'brand_id','id');
    }
}

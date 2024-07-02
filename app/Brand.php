<?php

namespace App;

use App\Product;
use App\Category;
use App\BillRecord;
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

    public function categories()
    {
        return $this->hasMany(Category::class, 'brand_id');
    }

    public function billRecords()
    {
        return $this->hasMany(BillRecord::class, 'brand_id');
    }
}

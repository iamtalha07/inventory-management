<?php

namespace App;

use App\Brand;
use App\BillRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = "categories";
    
    protected $fillable = [
        'name',
        'brand_id',
        'description',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function billRecords()
    {
        return $this->hasMany(BillRecords::class, 'category_id');
    }
}

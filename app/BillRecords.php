<?php

namespace App;

use App\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillRecords extends Model
{
    use SoftDeletes;
    protected $table = "bill_records";

    protected $fillable = [
        'brand_id',
        'category_id',
        'bill_no',
        'description',
        'billed_amount',
        'amount_paid',
        'adjusted_amount',
        'billed_date',
        'payment_date',
        'remarks',
        'generated_user',
        'created_at',
        'updated_at',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

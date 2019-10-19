<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'category_id',
        'details',
        'cost_price',
        'sales_price',
        'initial_stock',
        'total_stock',
        'unit',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    protected $appends = ['cost_price_format', 'sales_price_format'];

    public function getCostPriceFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['cost_price'], 2);
    }

    public function getSalesPriceFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['sales_price'], 2);
    }
}

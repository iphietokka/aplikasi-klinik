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
        'sale_price',
        'initial_stock',
        'total_stock',
        'unit',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    protected $appends = ['cost_price_format', 'sale_price_format'];

    public function getCostPriceFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['cost_price'], 2);
    }

    public function getsalePriceFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['sale_price'], 2);
    }
}

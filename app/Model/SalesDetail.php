<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    protected $fillable = ['sales_id', 'product_id', 'quantity', 'price', 'sub_total'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['sub_total_format', 'price_format'];


    public function sales()
    {
        return $this->belongsTo('App\Model\Sales', 'sales_id');
    }

    public function transact()
    {
        return $this->hasMany('App\Model\Transaction', 'sales_id', 'sales_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    public function getPriceFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['price'], 0, ',', '.');
    }

    public function getSubTotalFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['sub_total'], 0, ',', '.');
    }
}

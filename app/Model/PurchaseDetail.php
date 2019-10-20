<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetail extends Model
{
    use SoftDeletes;
    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'price'];
    protected $appends = ['price_format'];

    public function purchase()
    {
        return $this->belongsTo('App\Model\Purchase', 'purchase_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany('App\Model\Transaction', 'purchase_id', 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    public function getPriceFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['price'], 2);
    }
}

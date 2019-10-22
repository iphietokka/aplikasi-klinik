<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'purchase_date',
        'invoice_no',
        'supplier_id',
        'status',
        'total',
        'user_id',
        'active'
    ];

    protected $appends = ['total_format', 'price_format'];

    public function user_modify()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Model\Supplier');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Model\Transaction', 'id', 'purchase_id');
    }

    public function purchase()
    {
        return $this->belongsTo('App\Model\PurchaseDetail', 'id', 'purchase_id');
    }

    public function getPriceFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['price'], 2, ',', '.');
    }
    public function getTotalFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['total'], 2, ',', '.');
    }
}

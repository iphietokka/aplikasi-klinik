<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $appends = ['amount_format'];

    protected $dates = ['created_at', 'updated_at'];

    public function purchases()
    {
        return $this->hasOne('App\Model\Purchase', 'purchase_id', 'id');
    }

    public function sales()
    {
        return $this->hasOne('App\Model\Sales', 'sales_id', 'id');
    }

    public function transaction()
    {
        return $this->hasOne('App\Model\Transaction', 'purchase_id', 'purchase_id');
    }

    public function suppliers()
    {
        return $this->belongsTo('App\Model\Supplier');
    }

    public function getAmountFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['amount'], 2);
    }
}

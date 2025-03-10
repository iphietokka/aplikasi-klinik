<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $appends = ['net_total_format', 'paid_format', 'total_format'];

    public function purchases()
    {
        return $this->hasMany('App\Model\Purchase', 'purchase_id', 'id');
    }

    public function purchase_detail()
    {
        return $this->hasMany('App\Model\PurchaseDetail', 'purchase_id', 'purchase_id');
    }

    public function sales()
    {
        return $this->hasMany('App\Model\Sales', 'sales_id', 'id');
    }

    public function sales_detail()
    {
        return $this->hasMany('App\Model\SalesDetail', 'sales_id', 'sales_id');
    }

    public function payments()
    {
        return $this->hasOne('App\Model\Payment', 'invoice_no', 'invoice_no');
    }

    public function returnSales()
    {
        return $this->hasMany('App\Model\ReturnTransaction', 'invoice_no', 'invoice_no');
    }

    public function getTotalFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['total'], 0, ',', '.');
    }

    public function getNetTotalFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['net_total'], 0, ',', '.');
    }

    public function getPaidFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['paid'], 0, ',', '.');
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class ReturnTransaction extends Model
{
    use SoftDeletes;
    protected $appends = ['return_amount_format'];
    public function sales()
    {
        return $this->belongsTo('App\Model\SalesDetail', 'sales_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'returned_by');
    }

    public function getReturnAmountFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['return_amount'], 0, ',', '.');
    }
}

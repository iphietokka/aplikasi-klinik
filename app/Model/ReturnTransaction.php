<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class ReturnTransaction extends Model
{
    use SoftDeletes;

    public function sales()
    {
        return $this->belongsTo('App\Model\SalesDetail', 'sales_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'returned_by');
    }
}

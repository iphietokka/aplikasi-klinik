<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Sales extends Model
{
    use SoftDeletes;
    protected $fillable = ['sales_date', 'invoice_no', 'total', 'description', 'user_id', 'customer_id', 'active'];

    protected $appends = ['total_format'];

    public function sells()
    {
        return $this->belongsTo('App\Model\SaleDetail', 'id', 'sales_id');
    }

    public function user_modify()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function transact()
    {
        return $this->hasMany('App\Model\Transaction', 'id', 'sales_id');
    }

    public function customers()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id');
    }

    public function getTotalFormatAttribute($value)
    {
        return 'Rp' . number_format($this->attributes['total'], 2);
    }

    public function stockValidate($id)
    {
        $data = DB::table('products')
            ->select(DB::raw('sum(total_stock) as total'))
            ->where(['product_id' => $id])
            ->groupBy('id')
            ->first();

        if (count($data) > 0) {
            if ($data->total <= 0) {
                $total = 0;
            } else {
                $total = $data->total;
            }
        } else {
            $total = 0;
        }
        return $total;
    }
}

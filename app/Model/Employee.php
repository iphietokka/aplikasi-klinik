<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'address', 'phone', 'unit_id', 'status'
    ];

    public function units()
    {
        return $this->belongsTo('App\Model\Unit', 'unit_id', 'id');
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name'
    ];

    public function employees()
    {
        return $this->belongsTo('App\Model\Employee', 'employee_id', 'id');
    }
}

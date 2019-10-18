<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function employees()
    {
        return $this->belongsTo('App\Model\Units', 'id', 'unit_id');
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // public function products()
    // {
    //     return $this->hasManyThrough('App\Product', 'App\Subcategory');
    // }

    public function product()
    {
        return $this->hasMany('App\Product');
    }
}

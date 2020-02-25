<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table="categories";

    public function item()
    {
        return $this->hasMany('App\Item');
    }
}

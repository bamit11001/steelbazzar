<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table="brand";
    public function item()
    {
        return $this->hasMany('App\Item');
    }
}

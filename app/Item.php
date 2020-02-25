<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table="item";

    public function categories()
    {
        return $this->belongsTo('App\Categories', 'cat_id');
    }
    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id');
    }
    public function services()
    {
        return $this->hasMany('App\Services');
    }
    public function item_size()
    {
        return $this->hasMany('App\Item_size');
    }
}

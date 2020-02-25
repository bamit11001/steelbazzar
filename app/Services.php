<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
	protected $table="services";
	 protected $fillable = ['item_id', 'area_id', 'price','status','added_by', 'item_size_id'];
    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }
    public function area()
    {
        return $this->belongsTo('App\Area', 'area_id');
    }
    public function price_live()
    {
        return $this->hasOne('App\Price_live');
    }
    public function price_live_history()
    {
        return $this->hasOne('App\Price_live_history');
    }
    public function item_size()
    {
        return $this->belongsTo('App\Item_size');
    }
    public function categories()
    {
        return $this->hasOneThrough('App\Categories', 'App\Item');
    }
}

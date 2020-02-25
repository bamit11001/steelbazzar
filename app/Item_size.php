<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_size extends Model
{
    
	protected $table="item_size";
	protected $fillable = ['item_size','unit', 'status','added_by'];
    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }
    
}

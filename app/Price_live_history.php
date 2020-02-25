<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price_live_history extends Model
{
    protected $table="price_live_history";
    protected $fillable = ['price','item_id','added_by', 'area_id','services_id','region_id','gst','for_ex','delivery','size','grade','unit','sentiment','price_updated_at','item_size_id'];
	
	public function services()
    {
        return $this->belongsTo('App\Services');
    }
  
}

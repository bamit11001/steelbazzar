<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    public function template_services()
    {
        return $this->hasMany('App\Template_services');
    }
    public function services()
    {
        return $this->belongsTo('App\Services', 'services_id');
    }
}

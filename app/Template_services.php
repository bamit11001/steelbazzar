<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template_services extends Model
{
    public function templates()
    {
        return $this->belongsTo('App\Templates', 'templates_id');
    }
}

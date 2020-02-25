<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table="countries";
    public function area()
    {
        return $this->hasMany('App\Area');
    }
    public function user()
    {
        return $this->hasMany('App\User');
    }
    
}

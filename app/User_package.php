<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_package extends Model
{
    protected $table="user_package";
    public function user_package_services()
    {
        return $this->hasMany('App\User_package_services');
    }
    public function plans_validity()
    {
        return $this->belongsTo('App\Plans_validity', 'plan_validity_id');
    }
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

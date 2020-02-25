<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_package_services extends Model
{
    protected $table="user_package_services";
    public function user_package()
    {
        return $this->belongsTo('App\User_package', 'user_package_id');
    }
}

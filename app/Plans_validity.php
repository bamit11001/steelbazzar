<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plans_validity extends Model
{
   protected $table="plan_validity";
   public function user_package()
    {
        return $this->hasOne('App\User_package');
    }
}

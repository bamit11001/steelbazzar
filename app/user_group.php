<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class user_group extends Model
{
    use SoftDeletes;
    protected $table="user_group";

    public function user()
    {
        return $this->belongsTo('App\User', 'admin');
    }
}

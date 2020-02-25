<?php

namespace App;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table="area";
    public function service()
    {
        return $this->hasMany('App\Service');
    }
    public function services()
    {
        return $this->hasMany('App\Services');
    }
     public function countries()
    {
        return $this->belongsTo('App\Countries', 'country_id');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

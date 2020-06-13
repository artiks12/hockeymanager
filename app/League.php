<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    public function user() 
    {
        return $this->belongsTo('App\User'); 
    }
    public function team() 
    {     
        return $this->hasMany('App\Team');
    }
    public function season() 
    {     
        return $this->hasMany('App\Season');
    }
}

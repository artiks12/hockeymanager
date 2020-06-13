<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function team() 
    {
        return $this->belongsTo('App\Team'); 
    }
    public function field() 
    {     
        return $this->hasMany('App\Field');
    }
    public function goalie() 
    {     
        return $this->hasMany('App\Goalie');
    }
    public function penalty() 
    {     
        return $this->hasMany('App\Penalty');
    }
    public function goal() 
    {     
        return $this->hasMany('App\Goal');
    }
}

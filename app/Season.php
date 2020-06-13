<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    public function league() 
    {
        return $this->belongsTo('App\League'); 
    }
    public function team() 
    {     
        return $this->hasMany('App\Team');
    }
    public function teamStat() 
    {     
        return $this->hasMany('App\TeamStat');
    }
    public function game() 
    {     
        return $this->hasMany('App\Game');
    }
}

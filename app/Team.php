<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function league() 
    {
        return $this->belongsTo('App\League'); 
    }
    public function season() 
    {
        return $this->belongsTo('App\Season'); 
    }
    public function user() 
    {
        return $this->belongsTo('App\User'); 
    }
    public function teamStat() 
    {     
        return $this->hasMany('App\TeamStat');
    }
    public function player() 
    {     
        return $this->hasMany('App\Player');
    }
    public function game()
    {
        return $this->hasMany('App\Game');
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

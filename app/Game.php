<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'date', 'HostTeam', 'VisitingTeam', 'type'
    ];
    public function season() 
    {
        return $this->belongsTo('App\Season'); 
    }
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

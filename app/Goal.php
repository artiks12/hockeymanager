<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public function player() 
    {
        return $this->belongsTo('App\Player'); 
    }
    public function game() 
    {
        return $this->belongsTo('App\Game'); 
    }
    public function team() 
    {
        return $this->belongsTo('App\Team'); 
    }
}

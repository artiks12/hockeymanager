<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goalie extends Model
{
    public function player() 
    {
        return $this->belongsTo('App\Player'); 
    }
    public function game() 
    {
        return $this->belongsTo('App\Game'); 
    }
}

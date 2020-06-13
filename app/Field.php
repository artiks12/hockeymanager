<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
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

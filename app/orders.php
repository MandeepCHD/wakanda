<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{

  /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public function duser(){
    	return $this->belongsTo('App\users', 'user');
    }
   
}

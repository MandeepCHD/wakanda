<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_packs extends Model
{

    public function dpack(){
    	return $this->belongsTo('App\investment_packs', 'investment_pack');
    }
 
}

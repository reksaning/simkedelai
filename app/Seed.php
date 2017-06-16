<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seed extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
    	return $this->belongsTo('App/User');
    }

    public function onfarm(){
    	return $this->belongsTo('App\Onfarm');
    }
}

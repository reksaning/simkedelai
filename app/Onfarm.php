<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onfarm extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['updated_at', 'planted_at'];

    /*
	* RELATIONS SECTION
    */
    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function seed(){
        return $this->hasOne('App\Seed');
    }

    public function activity(){
        return $this->hasMany('App\Activity');
    }

    public function cost(){
        return $this->hasMany('App\OnfarmCost', 'onfarm_id', 'id');
    }

    public function harvest(){
        return $this->hasOne('App\Harvest');
    }

    /*
	* CUSTOM METHOD SECTION
    */
    public static function  addOnfarm($request)
    {
    	$request->user_id = $request->has('input_user') ? $request->input_user : $request->auth_user;
    	return static::create([
    		'name' => $request->name,
    		'user_id' => $request->user_id,
    		'description' => $request->description,
		]);
    }

    public function addActivity()
    {
        $activity = $this->activity()->create([
            'name' => request('name'),
            'description' => request('description'),
            'date' => request()->has('date') ? request('date') : request('planted_at'),
        ]);

        if(!empty(request('photo'))) $activity->uploadPhoto(request('photo'), $this->id);

        return $activity;
    }

    public function seedCost()
    {
        return empty($this->seed) ? 0 : $this->seed->quantity*$this->seed->price;
    }

    public function onfarmCost()
    {
        $onfarmCost = empty($this->cost) ? 0 : $this->cost->sum('price') ;

        return $this->seedCost() + $onfarmCost;
    }

    public function formattedSeedCost()
    {
        return number_format($this->seedCost(), 0, ',', '.');
    }

    public function formattedOnfarmCost()
    {
        return number_format($this->onfarmCost(), 0, ",", ".");
    }

    // URL SECTION
    public function viewUrl()
    {
        return "/onfarm/$this->id/view";
    }

    public function editUrl()
    {
        return "/onfarm/$this->id/edit";
    }

    public function createActivityUrl()
    {
        return "/activity/create/$this->id";
    }

    /**
    * Custom attribute
    */

    public function getHarvestEstimationAttribute()
    {
        $up = $this->planted_at->addDays(82)->format('j');
        $down = $this->planted_at->addDays(90)->format('j F Y');

        return $up.'&ndash;'.$down;
    }


}

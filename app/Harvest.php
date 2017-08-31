<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{

	public function postharvest(){
		return $this->hasMany('App\Postharvest');
	}

	public function onfarm(){
		return $this->belongsTo('App\Onfarm');
	}

	public function addPostharvest($request)
	{
		return $this->postharvest()->create([
			'name' => 'panen '.$this->onfarm->name,
			'cost' => $request->cost,
		]);
	}

	public function getSaleStatusAttribute()
	{
		return $this->on_sale ? 'Dijual' : 'Tidak dijual';
	}

	public static function totalStock()
	{
		$stock = auth()->user()->isSuperadmin() ? Harvest::all()->sum('ending_stock') : auth()->user()->harvest->sum('ending_stock');

		return $stock;
	}

	public static function onSaleStock()
	{
		$stock = auth()->user()->isSuperadmin() ? Harvest::where('on_sale', 1)->get()->sum('ending_stock') : auth()->user()->harvest()->where('on_sale', 1)->get()->sum('ending_stock');

		return $stock;
	}

	public function stockPercent()
	{
		return $this->ending_stock/$this->initial_stock*100;
	}
    
    protected $guarded = ['id'];
    protected $dates = ['harvested_at'];
}
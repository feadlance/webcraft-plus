<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
	protected $table = 'sales';
	
	protected $fillable = [
		'price',
		'execute',
		'ended_at'
	];

	protected $casts = [
		'execute' => 'boolean'
	];

	protected $dates = [
		'ended_at'
	]; 

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function server()
	{
		return $this->belongsTo('App\Models\Server');
	}

	public function users()
	{
		return $this->hasMany('App\Models\User', 'vip');
	}

	public function product()
	{
		return $this->belongsTo('App\Models\Product');
	}

	public function scopeDate($query, $date = null)
	{
		$q = date_query($date, $this->table);

		if ( $q === null ) {
			return $query;
		}
		
		return $query->whereRaw($q);
	}

	public function price()
	{
		return price_with_symbol($this->price, true);
	}
}
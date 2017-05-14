<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
	protected $fillable = [
		'admin',
		'body',
		'viewed_at'
	];

	protected $casts = [
		'admin' => 'boolean'
	];

	protected $dates = [
		'viewed_at'
	];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
	
	public function support()
	{
		return $this->belongsTo('App\Models\Support');
	}

	public function hasView()
	{
		return $this->viewed_at !== null;
	}

	public function setViewed()
	{
		$this->viewed_at = Carbon::now();
		$this->save();
	}
}
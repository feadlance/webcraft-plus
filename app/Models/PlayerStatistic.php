<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerStatistic extends Model
{
	protected $table = 'player_statistics';

	protected $casts = [
		'is_online' => 'boolean'
	];

	public function server()
	{
		return $this->belongsTo('App\Models\Server', 'servername', 'slug');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'username', 'username');
	}
}
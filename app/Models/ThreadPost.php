<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThreadPost extends Model
{
	use SoftDeletes;
	
	protected $table = 'thread_posts';

	protected $fillable = [
		'body'
	];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function thread()
	{
		return $this->belongsTo('App\Models\Thread');
	}
}
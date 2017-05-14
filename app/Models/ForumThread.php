<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumThread extends Model
{
	use SoftDeletes;
	
	protected $table = 'forum_threads';

	protected $fillable = [
		'title',
		'views_count',
		'closed_at'
	];

	protected $dates = ['closed_at'];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function forum()
	{
		return $this->belongsTo('App\Models\Forum');
	}

	public function posts()
	{
		return $this->hasMany('App\Models\ThreadPost', 'thread_id');
	}

	public function closed()
	{
		return $this->closed_at !== null;
	}
}
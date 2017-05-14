<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
	protected $table = 'forums';

	protected $fillable = [
		'name',
		'slug',
		'description',
		'icon',
		'order',
		'closed_at'
	];

	protected $dates = ['closed_at'];

	public function category()
	{
		return $this->belongsTo('App\Models\ForumCategory');
	}

	public function threads()
	{
		return $this->hasMany('App\Models\ForumThread');
	}

	public function posts()
	{
		return $this->hasManyThrough(
			'App\Models\ThreadPost',
			'App\Models\ForumThread',
			'forum_id',
			'thread_id'
		);
	}

	public function closed()
	{
		return $this->closed_at !== null;
	}
}
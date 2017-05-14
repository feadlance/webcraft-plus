<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = ['name', 'slug'];

	public function posts()
	{
		return $this->morphedByMany('App\Models\Post', 'taggable');
	}
}
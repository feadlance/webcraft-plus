<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
	protected $table = 'forum_categories';

	protected $fillable = [
		'name',
		'description',
		'order'
	];

	public function forums()
	{
		return $this->hasMany('App\Models\Forum', 'category_id');
	}
}
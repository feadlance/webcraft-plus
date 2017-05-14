<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = [
		'title',
		'slug',
		'body',
		'views_count'
	];

	protected $casts = ['views_count' => 'integer'];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function server()
	{
		return $this->belongsTo('App\Models\Server');
	}

	public function image()
	{
		return $this->belongsTo('App\Models\Image');
	}

	public function tags()
	{
		return $this->morphToMany('App\Models\Tag', 'taggable');
	}

	public function tagsHtml()
	{
		return implode(',', $this->tags->pluck('name')->toArray());
	}

	public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

	public function imageUrl($size = 'original')
	{
		return $this->image !== null ? $this->image->url($size) : asset("images/no-image-{$size}.jpg");;
	}

	public function category()
	{
		return $this->server ? $this->server->name : 'Genel';
	}

	public function color()
	{
		return $this->server ? $this->server->onlineStatusColor() : 'default';
	}
}
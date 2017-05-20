<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = [
		'body'
	];

	public function commentable()
	{
		return $this->morphTo();
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function deletePermission()
	{
		$user = auth()->user();

		if ( $user === null ) {
			return false;
		}

		return $user->isAdmin === true || $this->user->id === $user->id;
	}
}
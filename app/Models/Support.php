<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
	protected $fillable = [
		'title',
		'type',
		'closed_at'
	];

	protected $casts = [
		'type' => 'integer'
	];

	protected $dates = [
		'closed_at'
	];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function server()
	{
		return $this->belongsTo('App\Models\Server');
	}

	public function messages()
	{
		return $this->hasMany('App\Models\SupportMessage');
	}

	public function unViewedMessages($admin)
	{
		return $this->messages()->where('viewed_at', null)
			->where('admin', $admin);
	}

	public function subject()
	{
		$subjects = settings('lebby.support_types');

		return isset($subjects[$this->type]) ? $subjects[$this->type] : null;
	}

	public function category()
	{
		return $this->server !== null ? $this->server->name : __('Genel');
	}

	public function lastBody()
	{
		$last = $this->messages()->latest()->first();

		if ( $last === null ) {
			return null;
		}

		return $last->body;
	}
}
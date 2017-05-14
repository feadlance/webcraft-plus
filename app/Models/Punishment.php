<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
	protected $table = 'Punishments';

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'name', 'username');
	}

	public function history()
	{
		return $this->hasMany('App\Models\PunishmentHistory', 'name', 'name');
	}

	public function scopeActive($query)
	{
		return $query->where(function ($q) {
			$q->where(DB::raw("Unix_Timestamp(Now())"), '<', DB::raw("Substr(`end`, 1, Length(`end`) - 3)"))
				->orWhere('end', '-1');
		});
	}

	public function start()
	{
		$timestamp = mb_substr($this->start, 0, -3, 'UTF-8');

		return Carbon::createFromTimestamp($timestamp);
	}

	public function end()
	{
		if ( $this->end === '-1' ) {
			return null;
		}

		$timestamp = mb_substr($this->end, 0, -3, 'UTF-8');

		return Carbon::createFromTimestamp($timestamp);
	}

	public function remaining()
	{
		if ( $this->end() === null ) {
			return null;
		}

		return $this->end()->diffForHumans();
	}

	public function type()
	{
		$type = null;

		switch ( $this->punishmentType ) {
			case 'BAN': $type = __('Ban'); break;
			case 'TEMP_BAN': $type = __('Ban'); break;
			case 'WARNING': $type = __('Uyarı'); break;
			case 'TEMP_WARNING': $type = __('Uyarı'); break;
			case 'KICK': $type = __('Kick'); break;
			case 'MUTE': $type = __('Susturma'); break;
			case 'TEMP_MUTE': $type = __('Susturma'); break;
		}

		return $type;
	}
}
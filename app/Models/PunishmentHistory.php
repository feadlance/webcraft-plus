<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PunishmentHistory extends Model
{
	protected $table = 'PunishmentHistory';

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'name', 'username');
	}

	public function scopePasive($query)
	{
		return $query->where(function ($q) {
			$q->where(DB::raw("Unix_Timestamp(Now())"), '>=', DB::raw("Substr(`end`, 1, Length(`end`) - 3)"))
				->where('end', '!=', '-1');
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

	public function type()
	{
		$type = null;

		switch ( $this->punishmentType ) {
			case 'BAN': $type = 'Ban'; break;
			case 'TEMP_BAN': $type = 'Ban'; break;
			case 'WARNING': $type = 'Uyarı'; break;
			case 'TEMP_WARNING': $type = 'Uyarı'; break;
			case 'KICK': $type = 'Kick'; break;
			case 'MUTE': $type = 'Susturma'; break;
			case 'TEMP_MUTE': $type = 'Susturma'; break;
		}

		return $type;
	}
}
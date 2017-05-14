<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPayload extends Model
{
	protected $table = 'payment_payloads';

	protected $fillable = [
		'key',
		'trans_id',
		'money',
		'payload'
	];

	protected $casts = [
		'trans_id' => 'integer',
		'money' => 'double',
		'payload' => 'json',
	];

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function scopeDate($query, $date = null)
	{
		$q = date_query($date, $this->table);

		if ( $q === null ) {
			return $query;
		}

		return $query->whereRaw($q);
	}

	public function scopeRealMoney($query)
	{
		return $query->where('key', '!=', 'coupon');
	}

	public function money()
	{
		return price_with_symbol($this->money, true);
	}
}
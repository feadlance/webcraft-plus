<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCoupon extends Model
{
	protected $table = 'payment_coupons';

	protected $fillable = [
		'code',
		'credit',
		'piece'
	];

	protected $casts = [
		'credit' => 'double',
		'piece' => 'integer'
	];

	public function price()
	{
		return price_with_symbol($this->credit, true);
	}
}
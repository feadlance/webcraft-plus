<?php

namespace App\Helpers\Payments;

use App\Models\PaymentCoupon;

use Weblebby\Payments\PaymentParent;
use Weblebby\Payments\PaymentException;

class CouponPayment extends PaymentParent
{
	/**
	 * The validation rules.
	 *
	 * @param string $str
	 * @return array
	 */
	public function validation($str = null) {
		if ( in_array($str, ['rules', 'attributes']) !== true ) {
			$str = 'rules';
		}

		$rules = [
			'code' => 'required|max:100'
		];

		$attributes = [
			'code' => __('Kupon Kodu')
		];

		return $$str;
	}

	/**
	 * Load the class
	 *
	 * @param array $config
	 * @return void
	 */
	public function __construct(array $config = [])
	{
		//
	}

	/**
	 * Handle received request.
	 *
	 * @return array
	 */
	public function handle()
	{
		if ( isset($_POST['code']) !== true ) {
			throw new PaymentException("Gelen post eksik. [code]", 1);
		}

		$user = auth()->user();

		if ( $user === null ) {
			throw new PaymentException("Kullanıcı bulunamadı.", 1);
		}

		$coupon = PaymentCoupon::whereCode($_POST['code'])->first();

		if ( $coupon === null ) {
			throw new PaymentException("Kupon kodu geçersiz ya da bitti.", 1);
		}

		$post = [
			'trans_id' => $coupon->id,
			'username' => $user->username,
			'credit' => $coupon->credit
		];

		$this->post = $post;

		return $post;
	}

	/**
	 * Run if success.
	 *
	 * @return void
	 */
	public function finish()
	{
		if ( isset($this->post['trans_id']) !== true ) {
			return false;
		}

		$coupon = PaymentCoupon::find($this->post['trans_id']);

		if ( $coupon === null ) {
			throw new PaymentException("Kupon kodu geçersiz ya da bitti.", 1);
		}

		if ( $coupon->piece > 0 && $coupon->piece !== 1 ) {
			$coupon->piece = $coupon->piece - 1;
			$coupon->save();
		} else {
			$coupon->delete();
		}
	}

	/**
	 * Check same trans id.
	 *
	 * @param mixed $trans_ids
	 * @return boolean 
	 */
	public function checkTrans($trans_ids = [])
	{
		return $this->checkTransParent($trans_ids, $this->post);
	}
}
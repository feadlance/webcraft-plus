<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Models\PaymentCoupon;
use App\Models\PaymentPayload;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
	public function add()
	{
		return view('admin.coupon.add');
	}

	public function postAdd(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'code' => 'required|max:50|unique:payment_coupons',
			'piece' => 'required|numeric',
			'credit' => 'required|money'
		])->setAttributeNames([
			'code' => __('Kupon Kodu'),
			'piece' => __('Adet'),
			'credit' => __('Hediye Tutarı')
		])->validate();

		PaymentCoupon::create($request->only([
			'code',
			'piece',
			'credit'
		]));

		return redirect()->route('admin.coupon.list')
			->with('flash.success', __('Kupon başarıyla eklendi!'));
	}

	public function list()
	{
		$coupons = PaymentCoupon::latest()->get();

		return view('admin.coupon.list', compact(
			'coupons'
		));
	}

	public function delete($id)
	{
		$coupon = PaymentCoupon::find($id);

		if ( $coupon === null ) {
			return response_json(__('Sunucu bulunamadı.'));
		}

		$coupon->delete();

		return response_json(__('Kupon başarıyla silindi.'), true, $coupon);
	}

	public function detail($id)
	{
		$coupon = PaymentCoupon::find($id);

		if ( $coupon === null ) {
			return abort(404);
		}

		$payloads = PaymentPayload::latest()->has('user')
			->where('key', 'coupon')->where('trans_id', $id)
			->get();

		return view('admin.coupon.detail', compact(
			'coupon',
			'payloads'
		));
	}
}

















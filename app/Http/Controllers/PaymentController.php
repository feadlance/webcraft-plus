<?php

namespace App\Http\Controllers;

use Validator;
use Exception;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PaymentPayload;
use Weblebby\Payments\PaymentException;

class PaymentController extends Controller
{
	public function method($method)
	{
		$methodConfig = settings("lebby.payment_methods.{$method}");

		if ( $methodConfig === null || $methodConfig['active'] !== true ) {
			return abort(404);
		}

		$payment = new $methodConfig['class']($methodConfig['config']);

		return view("payment.{$method}", [
			'user' => auth()->user(),
			'method' => $methodConfig,
			'payment' => $payment
		]);
	}

	public function listener($method)
	{
		$methodConfig = settings("lebby.payment_methods.{$method}");

		if ( $methodConfig === null || $methodConfig['active'] !== true ) {
			return abort(404);
		}

		$payment = new $methodConfig['class']($methodConfig['config']);

		try {
			$post = $payment->handle();

			$user = User::whereUsername($post['username'])->first();

			if ( $user === null ) {
				return response_json(__('Kullanıcı bulunamadı.'));
			}

			$userTransIds = $user->payment_payloads()
					->where('key', $methodConfig['key'])
					->pluck('trans_id')
					->toArray();

			if ( $payment->checkTrans($userTransIds) !== true ) {
				return response_json(__('Bu ödemenin parası hesabınıza zaten eklendi.'));
			}

			if ( method_exists($payment, 'finish') ) {
				$payment->finish();
			}

			$user->payment_payloads()->create([
				'key' => $methodConfig['key'],
				'payload' => $post,
				'money' => $post['credit'],
				'trans_id' => $post['trans_id']
			]);

			$user->money = $user->money + $post['credit'];
			$user->save();

			return in_array($method, ['coupon']) ? $post : 'OK';
		} catch (PaymentException $e) {
			return response_json($e->getMessage());
		}
	}

	public function post(Request $request, $method)
	{
		$methodConfig = settings("lebby.payment_methods.{$method}");

		if ( $methodConfig === null || $methodConfig['active'] !== true ) {
			return abort(404);
		}

		$post = $request->all();

		if ( $methodConfig['key'] === 'paywant' ) {
			$user = User::whereUsername($request->input('username'))->first();

			if ( $user === null ) {
				return redirect()->route('payment.method', $method)->withInput()
					->with('flash.error', 'Kullanıcı bulunamadı.');
			}

			$post = array_merge($post, [
				'email' => $user->email,
				'user_id' => $user->id
			]);
		}

		$payment = new $methodConfig['class']($methodConfig['config'], $post);

		if ( method_exists($payment, 'validation') !== true ) {
			return abort(404);
		}

		$validator = Validator::make($request->all(), $payment->validation('rules'))
			->setAttributeNames($payment->validation('attributes'))
			->validate();
				
		if ( $methodConfig['key'] === 'paywant' ) {
			if ( $payment->response->Status !== 100 ) {
				return redirect()->route('payment.method', $method)->withInput()
					->with('flash.error', $payment->response->Message);
			}

			return redirect()->route('payment.method', $method)->with('iframe', $payment->response->Message);
		}

		$result = $this->listener($method);

		if ( isset($result->original['status'], $result->original['status_message']) ) {
			return redirect()->route('payment.method', $method)->withInput()
				->with('flash.error', $result->original['status_message']);
		}

		return redirect()->route('payment.method', $method)
			->with('flash.success', __('Tebrikler! Hesabınıza ' . price_with_symbol($result['credit'], true) . ' eklendi.'));
	}
}
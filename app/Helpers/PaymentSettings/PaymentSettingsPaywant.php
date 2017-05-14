<?php

namespace App\Helpers\PaymentSettings;

use Illuminate\Http\Request;

class PaymentSettingsPaywant extends PaymentSettingsParent
{
	/**
	 * Get config.
	 *
	 * @var $old
	 * @return object
	 */
	public function getConfig($old)
	{
		$method = settings('lebby.payment_methods.paywant');

		return (object) [
			'active' => $this->get($old, 'active') === 'true' ?: $method['active'],
			'key' => $this->get($old, 'key') ?: $method['config']['key'],
			'secret' => $this->get($old, 'secret') ?: $method['config']['secret'],
			'api_url' => $this->get($old, 'api_url') ?: $method['config']['api_url'],
		];
	}

	/**
	 * Get rules.
	 *
	 * @return array
	 */
	public function getRules()
	{
		return [
			'active' => 'in:true,false',
			'key' => 'max:100',
			'secret' => 'max:100',
			'api_url' => 'url|nullable'
		];
	}

	/**
	 * Get names.
	 *
	 * @return array
	 */
	public function getNames()
	{
		return [
			'active' => __('Aktif/Pasif'),
			'key' => __('Key'),
			'secret' => __('Secret'),
			'api_url' => __('API URL')
		];
	}

	/**
	 * Get settings.
	 *
	 * @var Request $request
	 * @return array
	 */
	public function getSettings(Request $request)
	{
		$methods = settings('lebby.payment_methods');

		array_set($methods, 'paywant.active', $request->input('active') === 'true');
		array_set($methods, 'paywant.config.key', $request->input('key'));
		array_set($methods, 'paywant.config.secret', $request->input('secret'));
		array_set($methods, 'paywant.config.api_url', $request->input('api_url'));

		return ['lebby.payment_methods' => $methods];
	}
}
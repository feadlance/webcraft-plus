<?php

namespace App\Helpers\PaymentSettings;

use Illuminate\Http\Request;

class PaymentSettingsBatihost extends PaymentSettingsParent
{
	/**
	 * Get config.
	 *
	 * @var $old
	 * @return object
	 */
	public function getConfig($old)
	{
		$method = settings('lebby.payment_methods.batihost');

		return (object) [
			'active' => $this->get($old, 'active') === 'true' ?: $method['active'],
			'id' => $this->get($old, 'id') ?: $method['config']['id'],
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
			'id' => 'numeric|nullable',
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
			'id' => __('Batıhost ID'),
			'secret' => __('Token'),
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

		array_set($methods, 'batihost.active', $request->input('active') === 'true');
		array_set($methods, 'batihost.config.id', $request->input('id'));
		array_set($methods, 'batihost.config.secret', $request->input('secret'));
		array_set($methods, 'batihost.config.api_url', $request->input('api_url'));

		return ['lebby.payment_methods' => $methods];
	}
}
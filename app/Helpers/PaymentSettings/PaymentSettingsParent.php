<?php

namespace App\Helpers\PaymentSettings;

use Illuminate\Http\Request;

class PaymentSettingsParent
{
	/**
	 * Get config.
	 *
	 * @var $key
	 * @var $old
	 * @return object
	 */
	public function config($key, $old = null)
	{
		$object = $this->class($key);

		if ( method_exists($object, 'getConfig') !== true ) {
			return null;
		}

		return (new $object)->{'getConfig'}($old);
	}

	/**
	 * Get rules.
	 *
	 * @var $key
	 * @return array
	 */
	public function rules($key)
	{
		$object = $this->class($key);

		if ( method_exists($object, 'getRules') !== true ) {
			return null;
		}

		return (new $object)->{'getRules'}();
	}

	/**
	 * Get names.
	 *
	 * @var $key
	 * @return array
	 */
	public function names($key)
	{
		$object = $this->class($key);

		if ( method_exists($object, 'getNames') !== true ) {
			return null;
		}

		return (new $object)->{'getNames'}();
	}

	/**
	 * Get settings.
	 *
	 * @var Request $request
	 * @var $key
	 * @return array
	 */
	public function settings(Request $request, $key)
	{
		$object = $this->class($key);

		if ( method_exists($object, 'getSettings') !== true ) {
			return null;
		}

		return (new $object)->{'getSettings'}($request);
	}

	/**
	 * Get array value if isset.
	 *
	 * @var $array
	 * @var $value
	 * @return mixed
	 */
	protected function get($array, $value)
	{
		return isset($array[$value]) ? $array[$value] : null;
	}

	/**
	 * Get class name.
	 *
	 * @var $name
	 * @return string
	 */
	protected function class($name)
	{
		return 'App\Helpers\PaymentSettings\\' . studly_case("payment_settings_{$name}");
	}
}
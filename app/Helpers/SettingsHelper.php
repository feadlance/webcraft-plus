<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
	static public function all()
	{
		if ( check_db_connection('tables') === false ) {
			return null;
		}

		return Setting::get();
	}

	static public function get($key)
	{
		if ( check_db_connection('tables') === false ) {
			return config($key);
		}

		$keyArray = explode('.', $key);

		if ( count($keyArray) < 2 ) {
			return config($key);
		}

		$setting = Setting::whereKey($keyArray[0] . '.' . $keyArray[1])->first();

		if ( $setting !== null ) {
			$value = self::unserialize($setting->value);

			if ( is_array($value) && count($keyArray) > 2 ) {
				return array_get($value, implode('.', array_except($keyArray, [0, 1])));
			}

			return $value;
		}

		return config($key);
	}

	static public function set($key, $value = null)
	{
		if ( check_db_connection('tables') === false ) {
			return null;
		}

		$settings = $key;

		if ( is_array($key) !== true ) {
			$settings = [$key => $value];
		}
		
		foreach ($settings as $key => $value) {
			if ( config($key) === $value ) {
				self::forget($key);
				continue;
			}

			Setting::updateOrCreate(['key' => $key], [
				'key' => $key,
				'value' => serialize($value)
			]);
		}
	}

	static public function forget($key)
	{
		if ( check_db_connection('tables') === false ) {
			return null;
		}
		
		Setting::whereKey($key)->delete();
	}

	static protected function unserialize($str)
	{
		$value = @unserialize($str);

		if ( $value !== false ) {
			return $value;
		}

		return $str;
	}
}
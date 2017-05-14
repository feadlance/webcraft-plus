<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'day',
		'name',
		'description',
		'commands',
		'prefix',
		'icon',
		'price',
		'type',
		'active'
	];

	protected $casts = [
		'day' => 'integer',
		'price' => 'double',
		'active' => 'boolean'
	];

	public function server()
	{
		return $this->belongsTo('App\Models\Server');
	}

	public function sales()
	{
		return $this->hasMany('App\Models\Sale');
	}

	public function toImageUrl()
	{
		$path = public_path("images/minecraft/{$this->icon}.png");

		if ( file_exists($path) ) {
			return asset("images/minecraft/{$this->icon}.png");
		}

		return asset("storage/product/{$this->icon}.png");
	}

	public function price()
	{
		return price_with_symbol($this->price, true);
	}

	public function givenCommands($player = false, $slash = false, $segment = 0)
	{
		$commands = explode("\n", $this->commands);

		foreach ($commands as $key => $value) {
			$commandSlash = mb_substr($commands[$key], 0, 1, 'UTF-8');

			if ( $slash === true && $commandSlash !== '/' && !empty($commands[$key]) ) {
				$commands[$key] = "/{$commands[$key]}";
			} else if ( $slash === false && $commandSlash === '/' ) {
				$commands[$key] = mb_substr($commands[$key], 1, null, 'UTF-8');
			}

			$commands[$key] = e($commands[$key]);
		}

		if ( $player !== false ) {
			$commands = str_replace('@p', $player, $commands);
		}

		$commands = implode("\n", $commands);
		$commands = explode("\n\n", $commands);

		if ( $segment === 0 ) {
			return $commands[0];
		}

		if ( isset($commands[1]) && $segment === 1 ) {
			return $commands[1];
		}
	}

	public function receivedCommands($player = false, $slash = false)
	{
		return $this->givenCommands($player, $slash, 1);
	}
}
<?php

namespace App\Models;

use Storage;
use App\Models\Sale;
use App\Models\User;

use Weblebby\GameConnect\Minecraft\Rcon as MinecraftRcon;
use Weblebby\GameConnect\Minecraft\Query as MinecraftQuery;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
	protected $table = 'servers';

	protected $fillable = [
		'name',
		'slug',
		'description',
		'ip',
		'host',
		'port',
		'status',
		'online',
		'slot',
		'rcon'
	];

	protected $casts = [
		'port' => 'integer',
		'status' => 'boolean',
		'online' => 'integer',
		'slot' => 'integer',
		'rcon' => 'json'
	];

	public function online_users()
	{
		if ( settings('lebby.bungeecord') === false ) {
			return User::online();
		}

		return $this->player_statistics()
			->where('is_online', true)
			->has('user');
	}

	public function player_statistics()
	{
		return $this->hasMany('App\Models\PlayerStatistic', 'servername', 'slug');
	}

	public function products()
	{
		return $this->hasMany('App\Models\Product');
	}

	public function posts()
	{
		return $this->hasMany('App\Models\Post');
	}

	public function supports()
	{
		return $this->hasMany('App\Models\Support');
	}

	public function sales()
	{
		return $this->hasMany('App\Models\Sale');
	}

	public function image()
	{
		return $this->belongsTo('App\Models\Image');
	}

	public function connectRcon()
	{
		return new MinecraftRcon($this->ip, $this->rcon['port'], $this->rcon['key']);
	}

	public function connectQuery()
	{
		return new MinecraftQuery($this->ip, $this->port);
	}

	public function updateQuery()
	{
		$query = $this->connectQuery();

		$this->status = $query->status;
		$this->slot = $query->slot ?: 0;
		$this->online = $query->online ?: 0;

		$this->save();
	}

	public function sendCommand($command)
	{
		$rcon = $this->connectRcon();

		if ( $rcon->authorized !== true ) {
			$this->updateQuery();
			
			return false;
		}

		$rcon->sendCommand($command);

		$log = '';
		$prefix = '[' . date('Y-m-d H:i:s') . ']: ';
		$path = storage_path("logs/console-{$this->id}.log");

		if ( file_exists($path) ) {
			$log = file_get_contents($path);
		}

		if ( empty($log) !== true ) {
			$log .= "\n";
		}

		$log .= $prefix . $command;

		if ( empty(trim($rcon->response)) !== true ) {
			$log .= "\n" . $prefix . str_replace("\n", null, $rcon->response);
		}

		Storage::disk('logs')->put("console-{$this->id}.log", $log);

		$this->updateQuery();

		return true;
	}

	public function deleteLog()
	{
		return Storage::disk('logs')->delete("console-{$this->id}.log");
	}

	public function imageUrl($size = 'original')
	{
		return $this->image !== null ? $this->image->url($size) : asset("images/no-image-{$size}.jpg");;
	}

	public function onlineStatusColor()
	{
		if ( $this->slot === 0 ) {
			return 'danger';
		}

		$percent = floor($this->online_users()->count() / ($this->slot / 100));

		if ( $percent <= 25 ) {
			return 'danger';
		}

		if ( $percent > 25 && $percent <= 60 ) {
			return 'warning';
		}

		if ( $percent > 60 ) {
			return 'success';
		}
	}
}
<?php

namespace App\Observers;

use App\Models\Server;

class ServerObserver
{
	public function creating(Server $server)
	{
		$server->slug = str_slug($server->name);
	}

	public function deleting(Server $server)
	{
		$server->deleteLog();
	}
}
<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Server;
use App\Models\Punishment;

class PunishmentController extends Controller
{
	public function getList()
	{
		$punishments = Punishment::has('user')->get();

		return view('admin.punishment.list', compact(
			'punishments'
		));
	}

	public function getDetail($id)
	{
		$user = User::find($id);

		if ( $user === null ) {
			return abort(404);
		}

		$punishments = $user->punishments()->active()->get();
		$punishmentHistory = $user->punishment_history()->pasive()->get();

		return view('admin.punishment.detail', compact(
			'user',
			'punishments',
			'punishmentHistory'
		));
	}

	public function deletePunishment($id)
	{
		$punishment = Punishment::find($id);

		if ( $punishment === null ) {
			return response_json(__('Ceza bulunamadı.'));
		}

		$server = Server::first();

		if ( $server === null ) {
			return response_json(__('Sistemde kayıtlı hiç sunucu yok. Oyuncunun cezasını kaldırabilmek için komut gönderebileceğimiz en az bir sunucuya ihtiyacımız var.'));
		}

		switch ( $punishment->punishmentType ) {
			case 'BAN': $command_string = "unban {$punishment->user->username}"; break;
			case 'TEMP_BAN': $command_string = "unban {$punishment->user->username}"; break;
			case 'WARNING': $command_string = "unwarn {$punishment->id}"; break;
			case 'TEMP_WARNING': $command_string = "unwarn {$punishment->id}"; break;
			case 'MUTE': $command_string = "unmute {$punishment->user->username}"; break;
			case 'TEMP_MUTE': $command_string = "unmute {$punishment->user->username}"; break;
			default: $command_string = null; break;
		}

		$command = $server->sendCommand($command_string);

		if ( $command === false ) {
			return response_json(__('Komut ":server" sunucusuna gönderilemedi, sunucu kapalı olabilir.', ['server' => $server->name]));
		}

		return response_json(__('Ceza başarıyla kaldırıldı.'), true, $punishment);
	}
}
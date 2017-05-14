<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\User;
use App\Models\Server;
use App\Models\Punishment;

class HomeController extends Controller
{
	public function home()
	{
		if ( settings('lebby.two_home_page') === false || auth()->check() === true ) {
			return $this->homeAuth();
		}

		$posts = Post::latest()->limit(3)->get();
		$servers = Server::orderBy('name', 'asc')->get();

		return view('home', compact(
			'posts',
			'servers'
		));
	}

	protected function homeAuth()
	{
		$posts = Post::latest()->limit(20)->get();
		$topPosts = Post::latest('views_count')->limit(7)->get();
		$onlineUserCount = User::online()->count();

		return view('home-auth', compact(
			'posts',
			'topPosts',
			'onlineUserCount'
		));
	}

	public function checkBan(Request $request)
	{
		$user = User::where('username', $request->username)->first();

		if ( $user === null ) {
			return response_json(__(':name banlı değil.', ['name' => e($request->username)]), true);
		}

		$punishment = $user->punishments()
			->whereIn('punishmentType', ['BAN', 'TEMP_BAN'])
			->active()->first();

		if ( $punishment === null ) {
			return response_json(__(':name banlı değil.', ['name' => e($request->username)]), true);
		}

		$messages = ['Bu oyuncu ban yemiş.<br>'];

		if ( $punishment->reason !== 'none' && empty($punishment->reason) !== true ) {
			$messages[] = __("Sebep: :reason", ['reason' => $punishment->reason]);
		} else {
			$messages[] = __('Sebep: :reason', ['reason' => __('(Sebepsiz)')]);
		}

		if ( $punishment->end !== '-1' ) {
			$messages[] = __("Bitiş: :time", ['time' => $punishment->end()->diffForHumans()]);
		} else {
			$messages[] = __("Bitiş: :time", ['time' => __('Sınırsız')]);
		}

		return response_json(implode('<br>', $messages), false, $punishment);
	}
}
<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Server;
use App\Repositories\IconRepository;

class UserController extends Controller
{
	public function list(Request $request, $filter = null)
	{
		$users = User::latest();

		if ( $request->username ) {
			if ( User::where('username', $request->username)->count() > 0 ) {
				return redirect()->route('admin.user.detail', $request->username);
			}

			$users = $users->where('username', 'like', "{$request->username}%");
		}

		$random = User::inRandomOrder();

		if ( $filter === 'online' ) {
			$users = $users->online();
			$random = $random->online();
		}

		$random = $random->first();

		if ( $random !== null ) {
			$random = $random->nameOrUsername();
		}

		$users = $users->paginate(100);

		return view('admin.user.list', compact(
			'users',
			'random',
			'filter'
		));
	}

	public function detail($username)
	{
		$user = User::where('username', $username)->first();

		if ( $user === null ) {
			return abort(404);
		}

		$servers = Server::get();
		$punishments = $user->punishments()->active()->limit(5)->get();
		$firstServerId = $servers->first() ? $servers->first()->id : 0;

		return view('admin.user.detail', compact(
			'user',
			'servers',
			'punishments',
			'firstServerId'
		));
	}

	public function update($username)
	{
		$user = User::where('username', $username)->first();

		if ( $user === null ) {
			return abort(404);
		}

		$input = (object) [
			'username' => old('username') ?: $user->username,
			'name' => old('name') ?: $user->name,
			'email' => old('email') ?: $user->email,
			'is_admin' => old('is_admin') ?: ($user->isAdmin ? 'true' : 'false')
		];

		return view('admin.user.update', compact(
			'user',
			'input'
		));
	}

	public function postUpdate(Request $request, $username)
	{
		$user = User::where('username', $username)->first();

		if ( $user === null ) {
			return abort(404);
		}

		$validator = Validator::make($request->all(), [
			'name' => 'max:30',
			'email' => 'required|email' . ($user->email !== $request->email ? '|unique:users' : null),
			'is_admin' => 'required|in:true,false'
		])->setAttributeNames([
			'name' => __('İsim & Soyisim'),
			'email' => __('E-Posta'),
			'is_admin' => __('Oyuncu/Admin')
		])->validate();

		$is_admin = $request->input('is_admin') === 'true';

		if ( auth()->user()->username === $username && $is_admin === false ) {
			return redirect()->route('admin.user.update', $user->username)->withInput()
				->with('flash.error', __('Kendinizi oyuncu yapamazsınız.')); 
		}

		$user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->isAdmin = $is_admin;

		$user->save();

		return redirect()->route('admin.user.update', $user->username)
			->with('flash.success', __('Oyuncu bilgileri başarıyla güncellendi.'));
	}

	public function action(Request $request, $username)
	{
		$user = User::where('username', $username)->first();

		if ( $user === null ) {
			return response_json(__('Kullanıcı bulunamadı.'));
		}

		if ( $user->server() === null ) {
			return response_json(__('Sunucuyla bağlantı kurulamadı.'));
		}

		$bungeecord = settings('lebby.bungeecord');

		$type = in_array($request->input('type'), [
			'sendMoney', 'sendMessage',
			'sendItem', 'ban', 'warn', 'kick'
		]) ? $request->input('type') : null;

		if ( $type === null ) {
			return response_json(__('Bir hata oluştu.'));
		}

		$defaultServer = Server::first();

		if ( $type === 'sendMoney' ) {
			$validator = Validator::make($request->all(), ['money' => 'required|money'])
				->setAttributeNames(['money' => __('Para')]);

			if ( $validator->fails() ) {
				return response_json($validator->errors()->first());
			}

			$user->money = $user->money + $request->input('money');
			$user->save();
		}

		if ( $type === 'sendMessage' ) {
			$validator = Validator::make($request->all(), ['message' => 'required|max:100'])
				->setAttributeNames(['message' => __('Mesaj')]);

			if ( $validator->fails() ) {
				return response_json($validator->errors()->first());
			}

			if ( $user->is_online() === false ) {
				return response_json(__('Oyuncu şuan çevrimiçi değil.'));
			}

			if ( $bungeecord === false ) {
				$defaultServer->sendCommand("tell {$user->username} {$request->input('message')}");
			} else {
				$user->server()->sendCommand("tell {$user->username} {$request->input('message')}");
			}
		}

		if ( $type === 'sendItem' ) {
			$validator = Validator::make($request->all(), [
				'server' => 'required|exists:servers,id',
				'item' => 'required|max:250',
				'piece' => 'max:250'
			])->setAttributeNames(['item' => __('Eşya Kodu'), 'piece' => __('Adet'), 'server' => __('Sunucu')]);

			if ( $validator->fails() ) {
				return response_json($validator->errors()->first());
			}

			if ( $user->is_online() === false ) {
				return response_json(__('Oyuncu şuan çevrimiçi değil.'));
			}

			$server = Server::find($request->input('server'));

			$server->sendCommand("i {$user->username} {$request->input('item')} {$request->input('piece')}");
		}

		if ( $type === 'ban' ) {
			$validator = Validator::make($request->all(), ['time' => 'max:15', 'reason' => 'max:100'])
				->setAttributeNames(['time' => __('Süre'), 'reason' => __('Sebep')]);

			if ( $validator->fails() ) {
				return response_json($validator->errors()->first());
			}

			$command = "ban {$user->username} {$request->input('reason')}";

			if ( $request->input('time') ) {
				$command = "tempban {$user->username} {$request->input('time')} {$request->input('reason')}";
			}

			if ( $bungeecord === false ) {
				$defaultServer->sendCommand($command);
			} else {
				$user->server()->sendCommand($command);
			}
		}

		if ( $type === 'warn' ) {
			$validator = Validator::make($request->all(), ['time' => 'max:15', 'reason' => 'max:100'])
				->setAttributeNames(['time' => __('Süre'), 'reason' => __('Sebep')]);

			if ( $validator->fails() ) {
				return response_json($validator->errors()->first());
			}

			$command = "warn {$user->username} {$request->input('reason')}";

			if ( $request->input('time') ) {
				$command = "tempwarn {$user->username} {$request->input('time')} {$request->input('reason')}";
			}

			if ( $bungeecord === false ) {
				$defaultServer->sendCommand($command);
			} else {
				$user->server()->sendCommand($command);
			}
		}

		if ( $type === 'kick' ) {
			$validator = Validator::make($request->all(), ['reason' => 'max:100'])
				->setAttributeNames(['reason' => __('Sebep')]);

			if ( $validator->fails() ) {
				return response_json($validator->errors()->first());
			}

			if ( $user->is_online() === false ) {
				return response_json(__('Oyuncu şuan çevrimiçi değil.'));
			}

			$command = "kick {$user->username} {$request->input('reason')}";

			if ( $bungeecord === false ) {
				$defaultServer->sendCommand($command);
			} else {
				$user->server()->sendCommand($command);
			}
		}

		return response_json(__('İşlem başarıyla gerçekleştirildi.'), true);
	}
}
<?php

namespace App\Http\Controllers\Admin;

use Storage;
use Validator;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Server;
use App\Helpers\ImageHelper;

use Weblebby\GameConnect\Minecraft\Rcon as MinecraftRcon;
use Weblebby\GameConnect\Minecraft\Query as MinecraftQuery;
use Weblebby\GameConnect\Minecraft\Color as MinecraftColor;

class ServerController extends Controller
{
	public function getCreate()
	{
		return view('admin.server.add');
	}

	public function postCreate(Request $request)
	{
		$input = $request->only([
			'name',
			'image',
			'description',
			'ip',
			'port',
			'rcon.key',
			'rcon.port'
		]);

		$input['host'] = $input['ip'];
		$input['ip'] = gethostbyname($input['ip']);

		if ( $input['port'] === null ) {
			$input['port'] = 25565;
		}

		if ( $input['rcon']['port'] === null ) {
			$input['rcon']['port'] = 25575;
		}

		$validator = Validator::make($input, [
			'name' => 'required|max:100|unique:servers',
			'image' => 'image|nullable',
			'description' => 'max:500',
			'ip' => 'required|ip',
			'port' => 'numeric|max:65535',
			'rcon.key' => 'required',
			'rcon.port' => 'numeric|max:65535'
		]);

		$query = new MinecraftQuery($input['ip'], $input['port']);

		if ( $query->status === false ) {
			$validator->after(function ($validator) {
				$validator->errors()->add('ip', __('Sunucuya bağlanılamadı, IP ve Portun doğruluğundan emin olun.'));
			});
		}

		$rcon = new MinecraftRcon($input['ip'], $input['rcon']['port'], $input['rcon']['key']);

		if ( $rcon->authorized !== true ) {
			$validator->after(function ($validator) {
				$validator->errors()->add('rcon.key', __('Lütfen Portun ve Şifrenin doğruluğundan emin olun.'));
			});
		}

		$validator->setAttributeNames([
			'name' => __('Sunucu Adı'),
			'description' => __('Açıklama'),
			'ip' => __('IP Adresi'),
			'port' => __('Port'),
			'rcon.key' => __('Rcon'),
			'rcon.port' => __('Port')
		])->validate();

		$input = array_merge($input, [
			'status' => true,
			'online' => $query->online,
			'slot' => $query->slot,
			'image' => null
		]);

		$server = Server::create($input);

		if ( $request->file('image') !== null ) {
			(new ImageHelper)->file($request->image)
				->sizes(270, 300)
				->database('servers', $server)
				->save();
		}

		return redirect()->route('admin.server.list')
			->with('flash.success', __('Sunucu başarıyla eklendi!'));
	}

	public function getList()
	{
		$servers = Server::latest()->get();

		return view('admin.server.list')
			->with('servers', $servers);
	}

	public function deleteServer($id)
	{
		$server = Server::find($id);

		if ( $server === null ) {
			return response_json(__('Sunucu bulunamadı.'));
		}

		$server->delete();

		return response_json(__('Sunucu başarıyla silindi.'), true, $server);
	}

	public function getDetail($slug)
	{
		$server = Server::whereSlug($slug)->first();

		if ( $server === null ) {
			return abort(404);
		}

		$onlinePlayers = $server->online_users()->get();
		$allProducts = $server->products->count();

		$products = $server->products()
			->latest()->limit(5)->get();

		$sales = $server->sales()->has('user')
			->latest()->limit(5)->get();

		$thisMonthPrices = _nf($server->sales()
			->date('this month')
			->sum('price'));

		$lastMonthPrices = _nf($server->sales()
			->date('last month')
			->sum('price'));

		$thisMonthSales = $server->sales()->date('this month')->count();
		$lastMonthSales = $server->sales()->date('last month')->count();

		return view('admin.server.detail', compact([
			'server',
			'allProducts',
			'products',
			'onlinePlayers',
			'sales',
			'thisMonthPrices',
			'thisMonthSales',
			'lastMonthPrices',
			'lastMonthSales'
		]));
	}

	public function postConsole()
	{
		$server = Server::find(request('server'));

		if ( $server === null ) {
			return response_json(__('Sunucu bulunamadı.'));
		}

		$command = request('command');

		if ( $command === null ) {
			return response_json(__('Komut geçersiz.'));
		}

		if ( $command !== '!clear' ) {
			$send = $server->sendCommand($command);

			if ( $send !== true ) {
				return response_json(__('Sunucu ile bağlantı sağlanamadı.'));
			}
		} else {
			$server->deleteLog();
		}

		return response_json(__('Komut başarıyla gönderildi.'), true);
	}

	public function postReadConsoleLog($id)
	{
		$path = storage_path("logs/console-{$id}.log");

		if ( file_exists($path) !== true ) {
			return response_json(__("Konsola sadece buradan girilen komutlar kaydedilir,\nKonsol çok dolduğunda temizlemek için !clear yazabilirsiniz."));
		}

		$log = file_get_contents($path);

		if ( empty($log) === true ) {
			return response_json(__('Buralar çok boş.'));
		}

		$log = MinecraftColor::html($log, true);

		return response_json('OK', true, $log);
	}
}

















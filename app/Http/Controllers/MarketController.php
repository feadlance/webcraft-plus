<?php

namespace App\Http\Controllers;

use View;
use Validator;
use Carbon\Carbon;
use App\Models\Server;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketController extends Controller
{
	public function index(Request $request)
	{
		$id = null;
		$product = Product::find($request->input('id'));

		if ( $product !== null && $product->active === true ) {
			$id = $product->id;
		}

		$servers = Server::orderBy('name', 'asc')->get();

		return view('market.index', compact(
			'id',
			'servers'
		));
	}

	public function postList()
	{
		$validator = Validator::make(request()->all(), [
			'server' => 'required|exists:servers,id',
			'type' => 'nullable|in:vip,item'
		]);

		if ( $validator->fails() ) {
			return response_json(__('Bir hata oluştu, lütfen sayfayı yenileyip tekrar deneyin.'));
		}

		$server = Server::find(request('server'));

		$products = $server->products()->whereActive(true);

		if ( request('type') !== null ) {
			$products = $products->where('type', request('type'));
		}

		if ( request('orderby') !== null ) {
			$orderby = explode('|', request('orderby'));

			$orderby_key = $orderby[0];
			$orderby_val = isset($orderby[1]) && in_array($orderby[1], ['asc', 'desc']) ? $orderby[1] : 'asc';

			$products = $products->orderBy($orderby_key, $orderby_val);
		}

		$paginate = 15;
		$page = request('page') ?: 1;

		if ( $products->paginate(15)->count() > 0 ) {
			request()->replace(['page' => $page]);
		} else {
			request()->replace(['page' => 1]);
		}

		$products = $products->paginate(15);

		$viewProducts = [];

		foreach ($products as $key => $product) {
			$viewProducts[$key]['searchQuery'] = $product->name;
			$viewProducts[$key]['view'] = View::make('components.product', compact('product', 'server'))->render();
		}

		$pagination = $products->links('components.pagination-vue')->toHtml();

		return response_json(__('Ürünler listelendi.'), true, compact(
			'viewProducts',
			'pagination'
		));
	}

	public function postDetail($id, $serverId)
	{
		$product = Product::whereActive(true)->find($id);

		if ( $product === null ) {
			return response_json(__('Ürün bulunamadı.'));
		}

		$product['priceFormat'] = $product->price();
		$product['imageUrl'] = $product->toImageUrl();
		$product['dayString'] = __('Süre: :count Gün', ['count' => $product->day]);

		$user = auth()->user();

		$userName = $user ? '<strong>' . $user->username . '</strong>' : '@p';

		$product['givenCommands'] = nl2br($product->givenCommands($userName, true));
		$product['receivedCommands'] = nl2br($product->receivedCommands($userName, true));

		return response_json('OK', true, $product);
	}

	public function postBuy($id, $serverId)
	{
		$user = auth()->user();

		if ( $user === null ) {
			return response_json(__('Satın almak için giriş yapmalısınız.'));
		}

		$product = Product::whereActive(true)->find($id);

		if ( $product === null ) {
			return response_json(__('Ürün bulunamadı.'));
		}

		$server = Server::find($serverId);

		if ( $server === null ) {
			return response_json(__('Sunucu bulunamadı.'));
		}

		if ( $user->money < $product->price ) {
			return response_json(__('Bu ürünü alabilmek için daha fazla paraya ihtiyacınız var.'));
		}

		$rcon = $server->connectRcon();

		if ( $rcon->authorized !== true ) {
			return response_json(__('Sunucuyla bağlantı sağlanamadı, lütfen yöneticiye bildirin.'));
		}

		if ( $user->is_online() !== true || ($user->server() && $user->server()->id !== $server->id) ) {
			return response_json(__('Bu ürünü satın alabilmek için :server sunucusunda çevrimiçi olmalısınız.', ['server' => $server->name]));
		}

		$givenCommands = explode("\n", $product->givenCommands($user->username));

		if ( $product->command_type === true ) {
			foreach ($givenCommands as $key => $value) {
				$product->servers->each->sendCommand(str_replace("\r", null, $value));
			}
		} else {
			foreach ($givenCommands as $key => $value) {
				$server->sendCommand(str_replace("\r", null, $value));
			}
		}

		$sale = $product->sales()->create([
			'price' => $product->price,
			'ended_at' => $product->day > 0 ? Carbon::now()->addDay($product->day) : null
		]);

		$user->sales()->save($sale);
		$server->sales()->save($sale);

		if ( $product->type === 'vip' ) {
			$sale->users()->save($user);
		}

		$user->money = $user->money - $product->price;
		$user->save();

		return response_json(__('Ürün başarıyla satın alındı.'), true, $product);
	}
}
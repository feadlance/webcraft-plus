<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Server;
use App\Models\Product;
use App\Repositories\IconRepository;
use Weblebby\GameConnect\Minecraft\Color;

class ProductController extends Controller
{
	public function create()
	{
		$icons = IconRepository::all();
		$servers = Server::orderBy('name', 'asc')->get();

		$prefix = Color::html('&3[&4&lVIP&3]');

		return view('admin.product.add', compact(
			'icons',
			'prefix',
			'servers'
		));
	}

	public function postCreate()
	{
		$input = request()->all();

		if ( $input['day'] == 0 ) {
			$input['day'] = null;
		}

		$validator = Validator::make($input, [
			'server_id' => 'required|exists:servers,id',
			'type' => 'required|in:vip,item',
			'prefix' => 'max:100',
			'name' => 'required|max:100',
			'given_commands' => 'required|max:600',
			'day' => 'numeric|nullable',
			'received_commands' => 'max:600|required_with:day',
			'icon' => 'required|in:' . implode(',', IconRepository::keys()),
			'description' => 'max:300',
			'price' => 'required|money'
		])->setAttributeNames([
			'server_id' => __('Sunucu'),
			'prefix' => __('Prefix'),
			'type' => __('Kategori'),
			'name' => __('Ürün Adı'),
			'given_commands' => __('Ürün Komutları'),
			'day' => __('Ürün Süresi'),
			'received_commands' => __('Süre Sonu Komutları'),
			'icon' => __('İkon'),
			'description' => __('Ürün Hakkında'),
			'price' => __('Fiyat')
		])->validate();

		$server = Server::find(request('server_id'));

		$commands = request('given_commands')
			. (request('day') > 0 ? "\n\n" . request('received_commands') : null);

		$product = $server->products()->create([
			'name' => request('name'),
			'description' => request('description'),
			'commands' => $commands,
			'prefix' => request('prefix'),
			'day' => request('day'),
			'icon' => request('icon'),
			'price' => nf_to_system(request('price')),
			'type' => request('type')
		]);

		return redirect()->route('admin.product.add')
			->with('flash.success', __('Ürün başarıyla eklendi.'));
	}

	public function list()
	{
		$server = Server::find(request('server'));

		$servers = Server::orderBy('name', 'asc')->get();
		$products = $server !== null ? $server->products()->latest()->where('active', true)->get() : [];

		return view('admin.product.list', compact('server', 'servers', 'products'));
	}

	public function set($id, $active)
	{
		$active = in_array($active, [0, 1]) ? $active : 1;
		
		$product = Product::find($id);

		if ( $product === null ) {
			return response_json(__('Ürün bulunamadı.'));
		}

		$product->update(['active' => $active]);

		return response_json(__($active ? 'Ürün başarıyla gösterime alındı.' : 'Ürün başarıyla gösterimden kaldırıldı.'), true, $product);
	}

	public function detail($id)
	{
		$product = Product::find($id);

		if ( $product === null ) {
			return abort(404);
		}

		$thisMonthPrices = _nf($product->sales()
			->date('this month')->sum('price'));

		$allPrices = _nf($product->sales()
			->date('all')->sum('price'));

		return view('admin.product.detail', compact(
			'thisMonthPrices',
			'allPrices',
			'product'
		));
	}

	public function color(Request $request)
	{
		return response_json('OK', true, Color::html(strip_tags($request->text)));
	}
}

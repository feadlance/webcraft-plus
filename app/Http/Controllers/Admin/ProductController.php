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
	public function getCreate()
	{
		$product = Product::find(request('id'));
		
		$icons = IconRepository::all();
		$servers = Server::orderBy('name', 'asc')->get();

		$form = $product === null ? (object) [
			'server_id' => old('server_id') ?: [],
			'command_type' => old('command_type') ? 'multiple' : 'single',
			'type' => old('type'),
			'prefix' => old('prefix'),
			'name' => old('name'),
			'given_commands' => old('given_commands'),
			'day' => old('day'),
			'received_commands' => old('received_commands'),
			'icon' => old('icon'),
			'description' => old('description'),
			'price' => old('price')
		] : (object) [
			'server_id' => old('server_id') ?: $product->servers()->pluck('id')->toArray(),
			'command_type' => (old('command_type') ?: $product->command_type) ? 'multiple' : 'single',
			'type' => old('type') ?: $product->type,
			'prefix' => old('prefix') ?: $product->prefix,
			'name' => old('name') ?: $product->name,
			'given_commands' => old('given_commands') ?: $product->givenCommands(),
			'day' => old('day') ?: $product->day,
			'received_commands' => old('received_commands') ?: $product->receivedCommands(),
			'icon' => old('icon') ?: $product->icon,
			'description' => old('description') ?: $product->description,
			'price' => old('price') ?: $product->price
		];

		$prefix = Color::html($form->prefix ?: '&3[&4&lVIP&3]');

		return view('admin.product.add', compact(
			'icons',
			'prefix',
			'servers',
			'form',
			'product'
		));
	}

	public function postCreate()
	{
		$input = request()->all();

		if ( $input['day'] == 0 ) {
			$input['day'] = null;
		}

		$validator = Validator::make($input, [
			'product' => 'nullable|exists:products,id',
			'server_id.0' => 'required|exists:servers,id',
			'server_id.*' => 'exists:servers,id',
			'command_type' => 'required|in:single,multiple',
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
			'server_id.*' => __('Sunucu'),
			'server_id.0' => __('Sunucu'),
			'command_type' => __('Komut Gönderme Türü'),
			'prefix' => __('Prefix'),
			'type' => __('Kategori'),
			'name' => __('Ürün Adı'),
			'given_commands' => __('Ürün Komutları'),
			'day' => __('Ürün Süresi'),
			'received_commands' => __('Süre Sonu Komutları'),
			'icon' => __('İkon'),
			'description' => __('Ürün Hakkında'),
			'price' => __('Fiyat'),
		])->validate();

		$commands = request('given_commands')
			. (request('day') > 0 ? "\n\n" . request('received_commands') : null);

		$data = [
			'name' => request('name'),
			'description' => request('description'),
			'commands' => $commands,
			'command_type' => request('command_type') === 'multiple',
			'prefix' => request('prefix'),
			'day' => request('day'),
			'icon' => request('icon'),
			'price' => nf_to_system(request('price')),
			'type' => request('type')
		];

		$product = Product::find(request('product'));

		if ( $product === null ) {
			$product = Product::create($data);
		} else {
			$product->update($data);
		}

		$product->servers()->sync(request('server_id'));

		return redirect()->route('admin.product.add', ['id' => $product->id])
			->with('flash.success', __('Ürün başarıyla eklendi.'));
	}

	public function getList()
	{
		$server = Server::find(request('server'));

		$servers = Server::orderBy('name', 'asc')->get();
		$products = $server !== null ? $server->products()->latest()->where('active', true)->get() : [];

		return view('admin.product.list', compact('server', 'servers', 'products'));
	}

	public function postSet($id, $active)
	{
		$active = in_array($active, [0, 1]) ? $active : 1;
		
		$product = Product::find($id);

		if ( $product === null ) {
			return response_json(__('Ürün bulunamadı.'));
		}

		$product->update(['active' => $active]);

		return response_json(__($active ? 'Ürün başarıyla gösterime alındı.' : 'Ürün başarıyla gösterimden kaldırıldı.'), true, $product);
	}

	public function getDetail($id)
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

	public function postColor(Request $request)
	{
		return response_json('OK', true, Color::html(strip_tags($request->text)));
	}
}

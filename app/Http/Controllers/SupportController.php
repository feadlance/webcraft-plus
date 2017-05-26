<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Server;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
	/**
	 * View 'support.add' file.
	 */
	public function getAdd()
	{
		$servers = Server::orderBy('name', 'asc')->get();
		$support_types = settings('lebby.support_types');

		return view('support.add', compact(
			'servers',
			'support_types'
		));
	}

	/**
	 * Create new support.
	 */
	public function postAdd(Request $request)
	{
		$user = $request->user();
		$support_types_keys = array_keys(settings('lebby.support_types'));

		$input = $request->all();

		if ( $input['server'] === '0' ) {
			$input['server'] = null;
		}

		$validator = Validator::make($input, [
			'server' => 'nullable|exists:servers,id',
			'title' => 'required|min:3|max:150',
			'type' => 'required|in:' . implode(',', $support_types_keys),
			'body' => 'required|min:10'
		])->setAttributeNames([
			'server' => 'Sunucu',
			'title' => 'Konu Başlığı',
			'type' => 'Problem',
			'body' => 'Mesaj'
		])->validate();

		$support = $user->supports()->create([
			'title' => request('title'),
			'type' => request('type')
		]);

		$server = Server::find(request('server'));

		if ( $server !== null ) {
			$server->supports()->save($support);
		}

		$message = $support->messages()->create([
			'body' => allow_html_tags(request('body'))
		]);

		$user->support_messages()->save($message);

		return redirect()->route('support.list')
			->with('flash.success', __('Talebiniz başarıyla alındı, en kısa sürede dönüş yapılacaktır.'));
	}

	/**
	 * View 'support.list' file with Supports.
	 */
	public function getList(Request $request)
	{
		$supports = $request->user()->supports()
			->latest('updated_at')->get();

		return view('support.list', compact(
			'supports'
		));
	}

	/**
	 * View 'support.view' file.
	 */
	public function getView(Request $request, $id)
	{
		$support = Support::find($id);

		if ( $support === null ) {
			return abort(404);
		}

		$user = $request->user();

		if ( $support->user->id !== $user->id ) {
			return abort(404);
		}

		$support->unViewedMessages(true)->get()->each->setViewed();

		return view('support.view', compact('support'));
	}

	/**
	 * Add reply on support.
	 */
	public function postReply(Request $request, $id)
	{
		$support = Support::find($id);

		if ( $support === null) {
			return redirect()->route('support.list')
				->with('flash.error', __('Bu talebi bulamadık.'));
		}

		if ( $support->closed_at !== null ) {
			return abort(404);
		}

		$user = $request->user();

		if ( $support->user->id !== $user->id ) {
			return abort(404);
		}

		$validator = Validator::make($request->all(), [
			'body' => 'required|min:10'
		])->setAttributeNames([
			'body' => 'Yanıtınız'
		])->validate();

		$message = $support->messages()->create([
			'body' => allow_html_tags(request('body'))
		]);

		$user->support_messages()->save($message);

		return redirect()->route('support.view', $id)
			->with('flash.success', __('Yanıtınız başarıyla iletildi.'));
	}

	/**
	 * Close support panel.
	 */
	public function postClose(Request $request, $id)
	{
		$support = Support::find($id);

		if ( $support === null ) {
			return abort(404);
		}

		$user = $request->user();

		if ( $support->user->id !== $user->id && $user->isAdmin !== true ) {
			return abort(404);
		}

		$support->closed_at = Carbon::now();
		$support->save();

		return redirect()->back()->with('flash.success', __('Konu başarıyla kapatıldı.'));
	}
}
<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Support;

class SupportController extends Controller
{
	public function list($type = null)
	{
		$operator = ($type === 'closed' ? '!' : '') . '=';

		$supports = Support::where('closed_at', $operator, null)->latest('updated_at')->get();

		return view('admin.support.list', compact(
			'supports',
			'type'
		));
	}

	public function listArchive()
	{
		return $this->list('closed');
	}

	public function reply(Request $request, $id)
	{
		$support = Support::find($id);

		if ( $support === null ) {
			return abort(404);
		}

		$support->unViewedMessages(false)->get()->each->setViewed();

		return view('admin.support.reply', compact('support'));
	}

	public function postReply(Request $request, $id)
	{
		$support = Support::find($id);

		if ( $support === null ) {
			return redirect()->route('admin.support.list');
		}

		if ( $support->closed_at !== null ) {
			return abort(404);
		}

		$validator = Validator::make(request()->all(), [
			'body' => 'max:600'
		]);

		if ( $validator->fails() ) {
			return redirect()->route('admin.support.reply', $id)
				->withInput()->with('flash.error', __('Yanıtınızın uzunluğu 600 karakteri geçmemeli.'));
		}

		$message = $support->messages()->create([
			'admin' => true,
			'body' => request('body')
		]);

		$request->user()->support_messages()->save($message);

		return redirect()->route('admin.support.reply', $id)
			->with('flash.success', __('Yanıtınız gönderildi.'));
	}
}
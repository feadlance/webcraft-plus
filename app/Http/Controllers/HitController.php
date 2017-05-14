<?php

namespace App\Http\Controllers;

use DB;
use View;
use Validator;
use App\Models\Server;
use App\Models\PlayerStatistic;
use Illuminate\Http\Request;

class HitController extends Controller
{
	public function top100()
	{
		if ( settings('lebby.bungeecord') === false ) {
			return view('hit.unsupport');
		}

		$servers = Server::orderBy('name', 'asc')->get();

		return view('hit.top100', compact(
			'servers'
		));
	}

	public function postTop100(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'server' => 'nullable|exists:servers,slug'
		])->setAttributeNames([
			'server' => 'Sunucu'
		]);

		if ( $validator->fails() ) {
			return response_json('Validation error.', false, $validator->errors());
		}

		$statistics = PlayerStatistic::where('player_kills', '>', 0)
			->latest('player_kills')
			->latest('mob_kills')
			->oldest('deaths')
			->limit(100);

		if ( empty(request('server')) === true ) {
			$statistics = $statistics->groupBy('username')->select(
				'username',
				DB::raw('Sum(player_kills) as player_kills'),
				DB::raw('Sum(mob_kills) as mob_kills'),
				DB::raw('Sum(deaths) as deaths')
			);
		} else {
			$statistics = $statistics->where('servername', request('server'));
		}

		$views = [];

		foreach ($statistics->get() as $key => $statistic) {
			$views[] = View::make('hit.top100-item', compact(
				'key',
				'statistic'
			))->render();
		}

		return response_json('OK', true, $views);
	}
}
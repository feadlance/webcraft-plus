<?php

namespace App\ViewComposers;

use DB;
use App\Models\User;
use App\Models\Sale;
use App\Models\PlayerStatistic;
use Illuminate\View\View;

class SidebarComposer
{
	public function compose(View $view)
	{
		$lastSales = Sale::has('user')
			->latest()->limit(5)
			->get();

		$topKills = PlayerStatistic::has('user')
			->where('player_kills', '>', 0)
			->latest('player_kills')
			->latest('mob_kills')
			->oldest('deaths')
			->limit(5)->get();

		$lastCreditUsers = User::join('payment_payloads', 'payment_payloads.user_id', '=', 'users.id')
			->select(['users.id', 'users.username', 'users.name', 'users.vip', DB::raw('Sum(`payment_payloads`.`money`) as `money`'), DB::raw('Count(`payment_payloads`.`money`) as `total`'), 'payment_payloads.created_at'])
			->where('payment_payloads.key', '!=', 'coupon')
			->whereRaw(date_query('this month', 'payment_payloads'))
			->groupBy('users.id')->latest('money')
			->limit(5)
			->get();

		$view->with('lastSales', $lastSales);
		$view->with('topKills', $topKills);
		$view->with('lastCreditUsers', $lastCreditUsers);
	}
}
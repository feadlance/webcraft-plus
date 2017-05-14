<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Sale;
use App\Models\Comment;
use App\Models\Support;
use App\Models\Punishment;
use App\Models\PaymentPayload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function dashboard()
	{
		$lastUsers = User::latest()->limit(5)->get();
		$onlineUsers = User::online()->limit(5)->get();

		$thisMonthPrice = _nf(PaymentPayload::realMoney()->date('this month')->sum('money'));
		$lastMonthPrice = _nf(PaymentPayload::realMoney()->date('last month')->sum('money'));
		
		$lastSales = Sale::has('user')->latest()->limit(5)->get();
		$lastPaymentPayloads = PaymentPayload::has('user')->realMoney()->latest()->limit(5)->get();

		$lastComments = Comment::has('user')->latest()->limit(5)->get();
		$lastSupports = Support::has('user')->latest()->whereNull('closed_at')->limit(5)->get();

		$lastPunishments = Punishment::has('user')->active()->limit(5)->get();

		return view('admin.dashboard', compact(
			'lastUsers',
			'onlineUsers',
			'thisMonthPrice',
			'lastMonthPrice',
			'lastSales',
			'lastPaymentPayloads',
			'lastComments',
			'lastSupports',
			'lastPunishments'
		));
	}	
}

<?php

namespace App\ViewComposers;

use App\Models\User;
use Illuminate\View\View;

class OnlineUsersComposer
{
	public function compose(View $view)
	{
		$view->with('onlineUsers', User::online());
	}
}
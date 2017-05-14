<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\SupportMessage;

class SupportMessageObserver
{
	public function created(SupportMessage $message)
	{
		$message->support()->touch();
	}
}
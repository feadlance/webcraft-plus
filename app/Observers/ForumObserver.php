<?php

namespace App\Observers;

use App\Models\Forum;

class ForumObserver
{
	public function creating(Forum $forum)
	{
		$forum->slug = str_slug($forum->name);
	}
}
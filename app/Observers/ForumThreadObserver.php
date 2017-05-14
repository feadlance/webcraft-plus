<?php

namespace App\Observers;

use App\Models\ForumThread;

class ForumThreadObserver
{
	public function creating(ForumThread $thread)
	{
		$thread->slug = str_slug($thread->title);
	}

	public function created(ForumThread $thread)
	{
		if ( auth()->check() !== true ) {
			return false;
		}

		auth()->user()->forum_threads()->save($thread);
	}
}
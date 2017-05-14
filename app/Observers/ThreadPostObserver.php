<?php

namespace App\Observers;

use App\Models\ThreadPost;

class ThreadPostObserver
{
	public function created(ThreadPost $post)
	{
		if ( auth()->check() !== true ) {
			return false;
		}

		auth()->user()->thread_posts()->save($post);
	}
}
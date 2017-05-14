<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
	public function creating(Post $post)
	{
		$post->slug = str_slug($post->title);
	}

	public function deleted(Post $post)
	{
		$post->comments()->delete();
		$post->tags()->detach();
	}
}
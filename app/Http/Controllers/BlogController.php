<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Post;
use App\Models\Server;

class BlogController extends Controller
{
	public function getList($category = null)
	{
		$posts = Post::latest();

		$server = Server::whereSlug($category)->first();
		$servers = Server::has('posts')->orderBy('name', 'asc')->get();

		$title = __('Tüm Yazılar');

		if ( $server !== null ) {
			$title = $server->name;

			$posts->whereHas('server', function ($query) use ($category) {
				$query->where('servers.slug', $category);
			});
		} else if ( $category === 'general' ) {
			$title = __('Genel');
			$posts->whereNull('server_id');
		}

		$posts = $posts->paginate(15);

		return view('blog.list', compact(
			'posts',
			'servers', 
			'title', 
			'category'
		));
	}

	public function getDetail($slug)
	{
		$post = Post::whereSlug($slug)->first();

		if ( $post === null ) {
			return abort(404);
		}

		$post->views_count += 1;
		$post->save();

		$tags = [
			'description' => str_limit(strip_tags($post->body), 70),
			'tags' => $post->tagsHtml()
		];

		return view('blog.detail', compact('post', 'tags'));
	}

	public function postComment($id)
	{
		$post = Post::find($id);

		if ( $post === null ) {
			return abort(404);
		}

		$bodylen = mb_strlen(request('body'), 'UTF-8');

		if ( $bodylen > 300 ) {
			return redirect()->route('blog.detail', $post->slug)
				->with('flash.error', __('Yorumunuzun uzunluğu 300 karakteri geçmemeli.'));
		}

		if ( $bodylen <= 7 ) {
			return redirect()->route('blog.detail', $post->slug)
				->with('flash.error', __('Lütfen 1 cümle kurabilecek kadar kelime girin.'));
		}

		$comment = $post->comments()->create([
			'body' => request('body')
		]);

		auth()->user()->comments()->save($comment);

		return redirect()->route('blog.detail', "{$post->slug}#comments")
			->with('flash.success', __('Yorumunuz başarıyla gönderildi.'));
	}
}
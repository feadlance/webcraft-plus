<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Server;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
	public function add($id = null)
	{
		$post = Post::find($id);
		$servers = Server::orderBy('name', 'asc')->get();

		$input = $post === null ? (object) [
			'server_id' => old('server_id'),
			'title' => old('title'),
			'image' => null,
			'body' => old('body'),
			'tags' => old('tags')
		] : (object) [
			'server_id' => $post->server_id,
			'title' => $post->title,
			'image' => $post->image !== null ? $post->imageUrl() : null,
			'body' => $post->body,
			'tags' => $post->tagsHtml()
		];

		return view('admin.blog.add', compact(
			'post',
			'input',
			'servers'
		));
	}

	public function postAdd(Request $request)
	{
		$input = $request->only([
			'post', 'server', 'title',
			'image', 'body', 'tags'
		]);

		if ( $input['server'] === '0' ) {
			$input['server'] = null;
		}

		$post = Post::find($request->post);

		$validator = Validator::make($input, [
			'post' => $post !== null ? 'required|exists:posts,id' : 'nullable',
			'server' => 'exists:servers,id|nullable',
			'title' => 'required|min:5' . ($post === null ? '|unique:posts' : null),
			'image' => 'image|nullable',
			'body' => 'required|min:15'
		])->setAttributeNames([
			'server' => 'Sunucu',
			'title' => 'Başlık',
			'image' => 'Resim',
			'body' => 'İçerik'
		])->validate();

		$tag_ids = [];
		$tags = explode(',', $request->tags);	

		foreach ( $tags as $tag ) {
			if ( empty(trim($tag)) === true ) {
				continue;
			}

			$tagModel = Tag::whereName($tag)->first() ?: Tag::create(['name' => $tag]);
			$tag_ids[] = $tagModel->id;
		}

		$userPosts = auth()->user()->blog_posts();

		if ( $post === null ) {
			$post = $userPosts->create($request->only(['title', 'body']));
		} else {
			$post->update($request->only('title', 'body'));
		}

		if ( $post->user_id === null ) {
			$userPosts->save($post);
		}

		$post->tags()->sync($tag_ids);

		$server = Server::find($request->input('server'));

		if ( $server !== null ) {
			$server->posts()->save($post);
		}

		if ( $request->file('image') !== null ) {
			(new ImageHelper)->file($request->image)
				->sizes([[700, 460], [1920, 800]])
				->database('posts', $post)
				->save();
		}

		return redirect()->route('admin.blog.update', ['id' => $post->id])
			->with('flash.success', __('Yazı başarıyla kaydedildi.'));
	}

	public function update(Request $request)
	{
		if ( Post::find($request->id) === null ) {
			return abort(404);
		}

		return $this->add($request->id);
	}

	public function list()
	{
		$posts = Post::latest()->get();

		return view('admin.blog.list', compact(
			'posts'
		));
	}

	public function delete($id)
	{
		$post = Post::find($id);

		if ( $post === null ) {
			return response_json(__('Yazı bulunamadı.'));
		}

		$post->delete();

		return response_json(__('Yazı başarıyla silindi.'), true, $post);
	}
}
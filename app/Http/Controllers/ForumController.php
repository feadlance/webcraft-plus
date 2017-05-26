<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Models\Forum;
use App\Models\ForumThread;
use App\Models\ForumCategory;

class ForumController extends Controller
{
	/**
	 * View home page on forum.
	 */
	public function index()
	{
		$categories = ForumCategory::whereHas('forums')
			->orderBy('order', 'asc')
			->get();

		return view('forum.index', compact(
			'categories'
		));
	}

	/**
	 * View forum threads.
	 */
	public function getThreads($forum_slug)
	{
		$forum = Forum::whereSlug($forum_slug)->first();

		if ( $forum === null ) {
			return abort(404);
		}

		$threads = $forum->threads()->paginate(25);

		return view('forum.threads', compact(
			'forum',
			'threads'
		));
	}

	/**
	 * View add new thread page.
	 */
	public function getAdd($forum_slug)
	{
		$forum = Forum::whereSlug($forum_slug)->first();

		if ( $forum === null ) {
			return abort(404);
		}

		return view('forum.add', compact(
			'forum'
		));
	}

	/**
	 * Add new thread.
	 */
	public function postAdd(Request $request, $forum_slug)
	{
		$forum = Forum::whereSlug($forum_slug)->first();

		if ( $forum === null ) {
			return abort(404);
		}

		$validator = Validator::make($request->all(), [
			'title' => 'required|min:5|unique:forum_threads',
			'body' => 'required|min:15'
		])->setAttributeNames([
			'title' => 'Başlık',
			'body' => 'İçerik'
		])->validate();

		$thread = $forum->threads()->create([
			'title' => $request->title
		]);

		$post = $thread->posts()->create([
			'body' => $request->body
		]);

		return redirect()->route('forum.thread', [$forum->slug, $thread->slug]);
	}

	/**
	 * View thread.
	 */
	public function getThread($forum_slug, $thread_slug)
	{
		$forum = Forum::whereSlug($forum_slug)->first();

		if ( $forum === null ) {
			return abort(404);
		}

		$thread = $forum->threads()->whereSlug($thread_slug)->first();

		if ( $thread === null ) {
			return abort(404);
		}

		$posts = $thread->posts()->paginate(15);

		return view('forum.thread', compact(
			'forum',
			'thread',
			'posts'
		));
	}

	/**
	 * Reply a thread.
	 */
	public function postReply(Request $request, $forum_slug, $thread_slug)
	{
		$forum = Forum::whereSlug($forum_slug)->first();

		if ( $forum === null ) {
			return abort(404);
		}

		$thread = $forum->threads()->whereSlug($thread_slug)->first();

		if ( $thread === null ) {
			return abort(404);
		}

		$validator = Validator::make($request->all(), [
			'body' => 'required|min:10'
		])->setAttributeNames([
			'body' => 'Yanıt'
		]);

		if ( $validator->fails() ) {
			return redirect()->back()
				->with('flash.error', $validator->errors()->first());
		}

		$post = $thread->posts()->create([
			'body' => allow_html_tags(request('body'))
		]);

		$request->user()->thread_posts()->save($post);

		return redirect()->back()
			->with('flash.success', __('Yanıtınız başarıyla gönderildi.'));
	}
}
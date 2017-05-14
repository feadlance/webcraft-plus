<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
	public function delete($id)
	{
		$comment = Comment::find($id);

		if ( $comment->deletePermission() !== true ) {
			return redirect()->back()->with('flash.error', __('Bunu yapamazsınız!'));
		}

		if ( $comment === null ) {
			return abort(404);
		}

		$comment->delete();

		return redirect()->back()
			->with('flash.success', __('Yorum başarıyla silindi.'));
	}
}
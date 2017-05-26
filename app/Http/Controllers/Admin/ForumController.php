<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Forum;
use App\Models\ForumCategory;

class ForumController extends Controller
{
	public function getAdd($id = null)
	{
		$forum = Forum::find($id);
		$categories = ForumCategory::orderBy('order', 'asc')->get();

		$input = (object) [];
		$inputs = ['category_id', 'name', 'description', 'icon'];

		foreach ($inputs as $key => $value) {
			$input->{$value} = old($value) ?: ($forum !== null ? $forum->{$value} : null);
		}

		return view('admin.forum.add', compact(
			'forum',
			'input',
			'categories'
		));
	}

	public function postAdd(Request $request)
	{
		$forum = Forum::find($request->forum);
		$category = ForumCategory::find($request->category_id);

		Validator::make($request->all(), [
			'forum' => $forum !== null ? 'exists:forums,id' : 'nullable',
			'category_id' => 'required|exists:forum_categories,id',
			'name' => 'required|max:100' . ($forum === null ? '|unique:forums' : null),
			'description' => 'max:250',
			'icon' => 'max:100'
		])->setAttributeNames([
			'category_id' => __('Kategori'),
			'name' => __('Başlık'),
			'description' => __('Açıklama'),
			'icon' => __('İkon')
		])->validate();

		$data = $request->only('name', 'description', 'icon');

		if ( $forum === null ) {
			$forum = $category->forums()->create($data);
		} else {
			$forum->update($data);
			$category->forums()->save($forum);
		}

		return redirect()->route('admin.forum.update', ['id' => $forum->id])
			->with('flash.success', __('Forum başarıyla kaydedildi.'));
	}

	public function getUpdate(Request $request)
	{
		if ( Forum::find($request->id) === null ) {
			return abort(404);
		}

		return $this->add($request->id);
	}

	public function getList()
	{
		$categories = ForumCategory::whereHas('forums')
			->orderBy('order', 'asc')
			->get();

		return view('admin.forum.list', compact(
			'categories'
		));
	}

	public function deleteForum($id)
	{
		$forum = Forum::find($id);

		if ( $forum === null ) {
			return response_json(__('Forum bulunamadı.'));
		}

		$forum->delete();

		return response_json(__('Kategori başarıyla silindi.'), true, $forum);
	}

	public function categoryIndex($id = null)
	{
		$category = ForumCategory::find($id);
		$categories = ForumCategory::orderBy('order', 'asc')->get();

		$input = (object) [];
		$inputs = ['name', 'description'];

		foreach ($inputs as $key => $value) {
			$input->{$value} = old($value) ?: ($category !== null ? $category->{$value} : null);
		}

		return view('admin.forum.category', compact(
			'input',
			'category',
			'categories'
		));
	}

	public function postAddCategory(Request $request)
	{
		$category = ForumCategory::find($request->category);

		Validator::make($request->all(), [
			'name' => 'required|max:100' . ($category === null ? '|unique:forum_categories' : null),
			'description' => 'max:250'
		])->setAttributeNames([
			'name' => __('Kategori Başlığı'),
			'description' => __('Açıklama')
		])->validate();

		$category = ForumCategory::updateOrCreate(['id' => $request->category], $request->only([
			'name', 'description'
		]));

		return redirect()->route('admin.forum.category.index');
	}

	public function updateCategory(Request $request)
	{
		if ( ForumCategory::find($request->id) === null ) {
			return abort(404);
		}

		return $this->categoryIndex($request->id);
	}

	public function deleteCategory($id)
	{
		$category = ForumCategory::find($id);

		if ( $category === null ) {
			return response_json(__('Kategori bulunamadı.'));
		}

		$category->delete();

		return response_json(__('Kategori başarıyla silindi.'), true, $category);
	}
}
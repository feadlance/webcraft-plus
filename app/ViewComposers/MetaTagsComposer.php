<?php

namespace App\ViewComposers;

use Illuminate\View\View;

class MetaTagsComposer
{
	protected $tags;

	public function __construct()
	{
		$this->tags = array_merge([
			'author' => 'Davutabi',
			'theme-color' => '#141619'
		], settings('lebby.meta') ?: []);
	}

	public function compose(View $view)
	{
		$view->with('metaTags', $this->tags);
	}
}
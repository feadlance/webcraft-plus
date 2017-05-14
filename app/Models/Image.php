<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	protected $table = 'images';

	protected $fillable = [
		'name',
		'description',
		'path'
	];

	public function posts()
	{
		return $this->hasMany('App\Models\Post');
	}

	public function servers()
	{
		return $this->hasMany('App\Models\Server');
	}

	public function url($size = 'original')
	{
		$path = str_replace('{size}', $size, $this->path);

		if ( file_exists(base_path("storage/app/public/{$path}")) !== true ) {
			$size = str_replace('original', '270x300', $size);

			return asset("images/no-image-{$size}.jpg");
		}

		return asset("storage/{$path}");
	}
}
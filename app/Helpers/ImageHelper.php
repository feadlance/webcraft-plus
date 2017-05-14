<?php

namespace App\Helpers;

use Image;
use App\Models\Image as ImageModel;
use Illuminate\Http\UploadedFile;

class ImageHelper
{
	/**
	 * The file.
	 *
	 * @var Illuminate\Http\UploadedFile $file
	 */
	protected $file;

	/**
	 * File path.
	 *
	 * @var string $path
	 */
	protected $path;

	/**
	 * File folder.
	 *
	 * @var string $folder
	 */
	protected $folder;

	/**
	 * File sizes.
	 *
	 * @var array $sizes
	 */
	protected $sizes = [];

	/**
	 * File name.
	 *
	 * @var string $name
	 */
	protected $name;

	/**
	 * Database Image model.
	 *
	 * @var App\Models\Image $model
	 */
	public $model;

	/**
	 * Init the class.
	 */
	public function __construct()
	{
		/**
		 * Default file name.
		 */
		$this->name = str_random(16);

		/**
		 * Default file path.
		 */
		$this->path = 'storage/app/public';

		/**
		 * Default file folder.
		 */
		$this->folder = 'images/' . date('Y-m-d');
	}

	/**
	 * Set the file.
	 *
	 * @param Illuminate\Http\UploadedFile $file
	 * @return $this
	 */
	public function file(UploadedFile $file)
	{
		$this->file = $file;

		return $this;
	}

	/**
	 * Set the name.
	 *
	 * @param string $name
	 * @return $this
	 */
	public function name($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Set the path.
	 *
	 * @param string $path
	 * @return $this
	 */
	public function path($path)
	{
		$this->path = $path;

		return $this;
	}

	/**
	 * Set the folder.
	 *
	 * @param string $path
	 * @return $this
	 */
	public function folder($folder)
	{
		$this->folder = $folder;

		return $this;
	}

	/**
	 * Set the sizes.
	 *
	 * @param integer|array $width
	 * @param integer|null $height
	 * @return $this
	 */
	public function sizes($width, $height = null)
	{
		$sizes = [];

		if ( is_array($width) !== true && (is_numeric($width) && is_numeric($height)) ) {
			$sizes[] = [$width, $height];
		} else {
			$sizes = $width;
		}

		$this->sizes = $sizes;

		return $this;
	}

	/**
	 * Save the image.
	 *
	 * @return $this
	 */
	public function save()
	{
		if ( $this->file === null ) {
			return false;
		}

		$folder = base_path($this->path . '/' . $this->folder);

		if ( file_exists($folder) !== true ) {
			mkdir($folder, 0777, true);
		}

		$image = Image::make($this->file->getRealPath())
			->encode('jpg', 60)
			->save($this->getFullPath($this->name, 'original'));

		foreach ($this->sizes as $key => $size) {
			$image = Image::make($this->file->getRealPath())
				->encode('jpg', 60)
				->resizeCanvas($size[0], $size[1])
				->save($this->getFullPath($this->name, $size));
		}

		return $this;
	}

	/**
	 * Save image on database.
	 *
	 * @param string $function
	 * @param mixed $model
	 * @return $this
	 */
	public function database($function = null, $model = null)
	{
		$name = "{$this->name}-{size}.jpg";

		$image = ImageModel::create([
			'path' => "{$this->folder}/{$name}"
		]);

		if ( empty($function) !== true && empty($model) !== true ) {
			$image->$function()->save($model);
		}

		$this->model = $image;

		return $this;
	}

	/**
	 * Get full name.
	 *
	 * @return string
	 */
	public function fullName()
	{
		if ( $this->file === null ) {
			return false;
		}

		return $this->name . '.' . $this->file->getClientOriginalExtension();
	}

	/**
	 * Get full path.
	 *
	 * @param string $name
	 * @param string|array $size
	 *
	 * @return string
	 */
	protected function getFullPath($name, $size)
	{
		$full_path = "{$this->path}/{$this->folder}/{$name}-";

		if ( is_array($size) === true && isset($size[0], $size[1]) === true ) {
			$full_path = $full_path . "{$size[0]}x{$size[1]}";
		} else {
			$full_path = $full_path . $size;
		}

		return base_path("{$full_path}.jpg");
	}
}
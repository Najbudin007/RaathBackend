<?php

namespace App\Mixins;

use Illuminate\Support\Str;

class OtherMixins
{

	/**
	 * Get the file path name
	 *
	 * @param  string $path
	 * @return array
	 */

	public function storage_path()
	{
		return function ($path) {
			if (is_null($path)) {
				return '';
			}
			return asset('storage/' . $path);
		};
	}

	/**
	 * Get the file  dimensions name
	 *
	 * @param  string $name
	 * @return array
	 */
	public function img_size()
	{
		return function ($name) {
			if (is_null($name)) {
				return '';
			}
			$width = config('custom.img_size.' . $name . '.width');
			$height = config('custom.img_size.' . $name . '.height');
			return 'NOTE: Image Dimension(W X H): ' . $width . 'px X ' . $height . 'px';
		};
	}
}

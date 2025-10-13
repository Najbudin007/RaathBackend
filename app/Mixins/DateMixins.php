<?php

namespace App\Mixins;

use Carbon\Carbon;

class DateMixins
{


	/**
	 * Convert current date to date string
	 */
	public function toCurrentDateString()
	{

		return function () {

			return Carbon::now()->toDateString();

		};
	}
	
	/**
	 * Convert date to date string
	 * @param $data string;
	 */
	public function toDateString()
	{
		return function ($date) {

			return Carbon::parse($date)->toDateString();
		};
	}


	/**
	 * Get  date time difference
	 * @param $d1 string;
	 * @param $d2 string;
	 */
	public function getDateTimeDiff()
	{
		return function ($d1, $d2) {

			return Carbon::parse($d1)->diff(Carbon::parse($d2));
		};
	}
}
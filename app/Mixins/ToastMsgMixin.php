<?php

namespace App\Mixins;

class ToastMsgMixin 
{
	/**
		 * Get the message and its type.
		 *
		 * @param  string $msg
		 * @param  string $type
		 * @return array
		*/
	
	public function toastMsg() 
	{
		return function ($msg, $type) {
			$notification = [
				'msg' => $msg,
				'type'=> $type
			];

			return $notification;

		};
	}

	public function responseSuccess()
	{
		return function ($status, $msg, $data = null) {
			$notification = [
				'status' => $status,
				'msg' => $msg,
				
			];
			if($data) {
				$notification['data'] = $data;
			}
			return $notification;

		};
	}

	public function responseErr()
	{
		return function (string $msg) {
			$notification = [
				'status' => false,
				'msg' => $msg,
				
			];
			return $notification;

		};
	}

	public function responseForbidden()
	{
		return function (string $msg) {
			$notification = [
				'status' => false,
				'msg' => $msg,
				
			];
			return $notification;

		};
	}
	
}
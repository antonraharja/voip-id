<?php

namespace Startup;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

class Output {

	/**
	 * Push responses to user agent (browser or external app)
	 * 
	 * @param  array $data Response dasta
	 * @return mixed Response::json() or Redirect::to()
	 * @static
	 */
	public static function push($data=array()) {

		$headers = ( isset($data['headers']) ? $data['headers'] : array() );
		$secure = ( isset($data['secure']) ? $data['secure'] : NULL );
		$options = ( isset($data['options']) ? $data['options'] : NULL );
		$input = ( isset($data['input']) ? TRUE : FALSE );

		if (Request::ajax() or Request::isJson() or Request::wantsJson()) {
			$status = '200';
			return Response::json($data, $status, $headers, $options);
		} else {
			$status = '302';
			$response = Redirect::to($data['path'], $status, $headers, $secure);
			if (isset($data['errors'])) {
				$response->withErrors($data['errors']);
			}
			if (isset($data['messages'])) {
				$response->with($data['messages']);
			}
			if ($input) {
				$response->withInput();
			}
			return $response;
		}

	}

}

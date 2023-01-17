<?php namespace App\Libraries\Api\Frontapi;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Session;
use Arr;

class Api {

	private static $logapi = true;

	// HELPER FUNCTIONS
	public static function getAuthorizationHeader() {
		return 'Authorization: Bearer ' . Arr::get(Session::get('user'), 'token', '');
	}

	public static function getEndpoint($options) {
		$endpoint 	= env('API_ENDPOINT_FRONT').Arr::get($options, 'api', '');
		$parameters = Arr::get($options, 'parameters', []);
		if(!empty($parameters) && is_array($parameters)) {
			$endpoint .= '?';
			$parameters_str = [];
			foreach($parameters as $key => $value) {
				$parameters_str[] = $key . '=' . urlencode($value);
			}
			$endpoint .= implode('&', $parameters_str);
		}
		return $endpoint;
	}

	public static function doLog() {
		return self::$logapi;
	}

	public static function callApi($options) {
		if(self::doLog()) {
			loginfo('===============================================');
			loginfo('IN callApi');
			loginfo('OPTIONS: ');
			loginfo($options);
		}

		// SET CURL WITH AUTHORIZATION BEARER
		$curl = Curl::to(self::getEndpoint($options))
		    		->returnResponseObject();

		// SET RAW DATA IF AVAILABLE
		$data = Arr::get($options, 'data', []);
		if(!empty($data)) {
			$curl = $curl->withData(json_encode($data));
		}

		// SET HEADERS IF AVAILABLE
		$headers = Arr::get($options, 'headers', []);
		if(!empty($headers)) {
			foreach($headers as $header) {
				$curl = $curl->withHeader($header);
			}
		}

		// SET LANGUAGE IF AVAILABLE
		$languageid = Session::get('languageid');
        if($languageid){
        	$current_language   = 'languageid: ' . $languageid;
            $curl = $curl->withHeader($current_language);
        }

        // SET LOCALE IF AVAILABLE
		$locale = Session::get('locale');
        if($locale){
        	$current_locale   = 'locale: ' . $locale;
            $curl = $curl->withHeader($current_locale);
        }

		// SET FILES IF AVAILABLE
		$files = Arr::get($options, 'files', []);
		if(!empty($files)) {
			foreach($files as $filename => $file) {
				$path 			= $file->getPathname();
				$mimetype 		= $file->getClientMimeType();
				$filenameorg 	= $file->getClientOriginalName();
				$curl 			= $curl->withFile($filename, $path, $mimetype, $filenameorg);
			}
		}

		// SEND THE CURL REQUEST BASED ON ITS METHOD
		switch(Arr::get($options, 'method', 'get')) {
			case 'get':
				$response = $curl->get();
			break;

			case 'post':
				$response = $curl->post();
			break;

			case 'delete':
				$response = $curl->delete();
			break;
		}


		// RETURN RESPONSE
		if(self::doLog()) {
			loginfo('RESPONSE CONTENT: ');
			loginfo($response->content);
			loginfo('===============================================');
		}
		return $response;

	}

	public static function callApiPostLogin($options = []) {

		if(self::doLog()) {
			loginfo('===============================================');
			loginfo('IN callApiPostLogin');
			loginfo('OPTIONS: ');
			loginfo($options);
		}



		// SET CURL WITH AUTHORIZATION BEARER
		$authheader = Arr::get($options, 'authheader');
		if(empty($authheader)) {
			$authheader = self::getAuthorizationHeader();
		}

		$curl = Curl::to(self::getEndpoint($options))
		    		->withHeader($authheader)
		    		->returnResponseObject();

		// SET RAW DATA IF AVAILABLE
		$data = Arr::get($options, 'data', []);
		if(!empty($data)) {
			// dd(json_encode($data, true));
			$curl = $curl->withData(json_encode($data, true));
		}

		// SET HEADERS IF AVAILABLE
		$contenttype = Arr::get($options, 'content-type', '');
		if(!empty($contenttype)) {
			$curl = $curl->withContentType($contenttype);
		}

		// SET HEADERS IF AVAILABLE
		$headers = Arr::get($options, 'headers', []);
		if(!empty($headers)) {
			foreach($headers as $header) {
				$curl = $curl->withHeader($header);
			}
		}

		// SET LANGUAGE IF AVAILABLE
		$languageid = Session::get('languageid');
        if($languageid){
        	$current_language   = 'languageid: ' . $languageid;
            $curl = $curl->withHeader($current_language);
        }

        // SET LOCALE IF AVAILABLE
		$locale = Session::get('locale');
        if($locale){
        	$current_locale   = 'locale: ' . $locale;
            $curl = $curl->withHeader($current_locale);
        }

		// SET FILES IF AVAILABLE
		$files = Arr::get($options, 'files', []);
		if(!empty($files)) {
			foreach($files as $filename => $file) {
				$path 			= $file->getPathname();
				$mimetype 		= $file->getClientMimeType();
				$filenameorg 	= $file->getClientOriginalName();
				$curl 			= $curl->withFile($filename, $path, $mimetype, $filenameorg);
			}
		}

		// SEND THE CURL REQUEST BASED ON ITS METHOD
		switch(Arr::get($options, 'method', 'get')) {
			case 'get':
				$response = $curl->get();
			break;

			case 'post':
				$response = $curl->post();
			break;

			case 'put':
				$response = $curl->put();
			break;

			case 'delete':
				$response = $curl->delete();
			break;
		}

		// ACCESS TOKEN EXPIRED
		if($response->status == 401) {

			// REFRESH TOKEN SET TO TRUE
			if(Arr::get($options, 'refresh-on-401', true)) {

				$user = Session::get('user');
	    		$token = $user['token'];
	    		$header = 'Authorization: Bearer ' . $token;


				// CALL REFRESH TOKEN
				$response_refreshtoken = self::callApi([
					'api' 			=> 'refresh-token',
					'method' 		=> 'get',
					'headers' 	=> [
						'Content-Type: application/json',
						$header
					]
				]);


				// TOKEN REFRESHED
				if($response_refreshtoken->status == 200) {

					$content = json_decode($response_refreshtoken->content, true)['data'];

					$user 					= Session::get('user');
					if(!empty($user)) {
						$user['token'] 			= Arr::get($content, 'token', '');
						$user['expires_in'] 	= Arr::get($content, 'expires_in', '');
					}

					Session::put('user', $user);

					$options['refresh-on-401'] = false;
					if(!empty(Arr::get($options, 'authheader'))) {
						$options['authheader'] = 'Authorization: Bearer ' . $user['accessToken'];
					}
					$response = self::callApiPostLogin($options);

					// RETURN RESPONSE
					if(self::doLog()) {
						loginfo('RESPONSE CONTENT: ');
						loginfo($response->content);
						loginfo('NEW USER: ');
						loginfo(Session::get('user'));
						loginfo('===============================================');
					}
					return $response;


				}
				// TOKEN REFRESH SOME ERROR
				else {

					Session::forget('user');

					// RETURN RESPONSE
					if(self::doLog()) {
						loginfo('RESPONSE CONTENT: ');
						loginfo($response->content);
						loginfo('===============================================');
					}
					return $response;

				}

			}
			// REFRESH TOKEN SET TO FALSE
			else {

				// RETURN RESPONSE
				if(self::doLog()) {
					loginfo('RESPONSE CONTENT: ');
					loginfo($response->content);
					loginfo('===============================================');
				}
				return $response;

			}

		}
		// ACCESS TOKEN NOT EXPIRED
		else {

			// RETURN RESPONSE
			if(self::doLog()) {
				loginfo('RESPONSE CONTENT: ');
				loginfo($response->content);
				loginfo('===============================================');
			}
			return $response;

		}
	}
}
<?php
use Illuminate\Support\Facades\Session;


if(!function_exists('getTempName'))
{
    function getTempName($path, $extension, $includepath=false) {
        do {
            $temp_file= $path . str_replace([' ', '.'], '_', microtime()) . '.' . $extension;
        } while(file_exists($temp_file));
        if($includepath)
            return $temp_file;
        else
            return basename($temp_file);
    }
}

if(!function_exists('forceHttps'))
{
    function forceHttps() {
    	return env('FORCE_HTTPS');
    }
}

if(!function_exists('getCacheCounter'))
{
    function getCacheCounter() {
    	return config('constants.cachecounter');
    }
}

if(!function_exists('loginfo'))
{
	function loginfo($content) {
		\Illuminate\Support\Facades\Log::info($content);
	}
}

if(!function_exists('cronjobloginfo'))
{
    function cronjobloginfo($content) {
    	$content = '[' . Carbon::now()->format('Y-m-d H:i:s') .'] production.INFO: '. json_encode($content);
 		file_put_contents(storage_path().'/logs/cronjob-'. Carbon::now()->format('Y-m-d') .'.log', $content.PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}

if ( ! function_exists('send_api_response'))
{
    function send_api_response($request, $data, $status_code, $headers) {

        return \Response::json($data, $status_code, $headers);

    }
}

function getProperDate($date, $format = '', $iscarbon = true) {
    $API_RESPONSE = strtolower(trim(env('API_RESPONSE')));
    /* OUTPUT AS JSON */
    if($API_RESPONSE == 'json') {

        if(is_null($date) || trim($date) == '') {
            return 0;
        }
        else {
            if($iscarbon) {
                return $date->timestamp;
            }
            else {
                return Carbon\Carbon::createFromFormat($format, $date)->timestamp;
            }

        }

    }
    /* OUTPUT AS XML */
    else {
        return trim($date);
    }
}

/* ADMIN START */
if ( ! function_exists('asset_admin') )
{
	function asset_admin($path) {
	    return asset('manage/'.ltrim($path, '/'));
	}
}

if ( ! function_exists('url_admin') )
{
	function url_admin($path) {

        $slug = 'manage';

        if(isset(auth('client')->user()->user_id)) {
            $slug = 'client';
        }
        elseif(isset(auth('member')->user()->user_id)) {
            $slug = 'member';
        }
	    return url($slug.'/'.ltrim($path, '/'));
	}
}

if ( ! function_exists('view_admin') )
{
	function view_admin($view, $data = []) {
		return view('manage.'.$view, $data);
	}
}
/* ADMIN END */



/* FRONT START */
if ( ! function_exists('asset_front') )
{
    function asset_front($path) {
        return asset('front/'.ltrim($path, '/'));
    }
}

if ( ! function_exists('view_front') )
{
    function view_front($view, $data = []) {
        return view('front.'.$view, $data);
    }
}

if ( ! function_exists('charge_amount') )
{
    function charge_amount($amount, $currency) {
    	$zero_decimal_currencies = config('constants.zero-decimal-currencies');
    	if(in_array($currency, $zero_decimal_currencies)){
    		$amount = floatval($amount);
    	}else{
    		$amount = (floatval($amount) * 100);
    	}
        return $amount;
    }
}

if ( ! function_exists('public_asset') )
{
	function public_asset($path) {
	    return asset(ltrim($path, '/'));
	}
}

if ( ! function_exists('view_front_theme') )
{
    function view_front_theme($view, $data = []) {
        return view('front.'.$view, $data);
    }
}
/* FRONT END */

//Translation
if ( ! function_exists('getTranslation') )
{
    function getTranslation($key) {
        $message = $key;
        $messages = Lang::get('messages');
        if( array_key_exists($key,$messages) && trim($messages[$key]) != "" ) {
            $message = $messages[$key];
        }
        return $message;
    }
}
//Translation

//API Message Translation
if ( ! function_exists('getAPITranslation') )
{
    function getAPITranslation($key) {
        $message = $key;
        $messages = Lang::get('api_messages');
        if( array_key_exists($key,$messages) && trim($messages[$key]) != "" ) {
            $message = $messages[$key];
        }
        return $message;
    }
}
//API Message Translation


//Logged in user
if ( ! function_exists('isUserLoggedIn') )
{
    function isUserLoggedIn() {
    	$user = Session::get('user');
        if(!empty($user)) {
        	return true;
        }else{
        	return false;
        }
    }
}
//Logged in user

/* =================== PRICE FORMATING FUNCTIONS ===================*/
if(!function_exists('formatPrice')) {
	function formatPrice($price, $decimalpoints = 2) {
		return (number_format((float)$price, $decimalpoints, '.', ','));
	}
}

if(!function_exists('formatPriceInteger')) {
    function formatPriceInteger($price) {
        return number_format((float)$price, 2, '.', '');
    }
}

if(!function_exists('convertToReadableSize')) {
    function convertToReadableSize($size) {
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);

        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }
}
/*=================== ADMIN RELATED FUNCTIONS ===================*/


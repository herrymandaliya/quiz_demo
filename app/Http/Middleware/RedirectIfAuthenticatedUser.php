<?php namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticatedUser {

	// protected $auth;

	// public function __construct() {
	// 	$this->auth = Auth::guard('user');
	// }

	public function handle($request, Closure $next)	{
		if (Auth::guard('admin')->check()) {
			if($request->ajax()) {
				$data 					= [];
				$data['type'] = 'success';
				$data['redirectUrl'] = url('/manage/dashboard');
				return response()->json($data);
			}
			else {
				return new RedirectResponse(url('/manage/dashboard'));
			}
		}
		elseif (Auth::guard('client')->check()) {
			if($request->ajax()) {
				$data 					= [];
				$data['type'] = 'success';
				$data['redirectUrl'] = url('/client/dashboard');
				return response()->json($data);
			}
			else {
				return new RedirectResponse(url('/client/dashboard'));
			}
		}
		return $next($request);
	}

}
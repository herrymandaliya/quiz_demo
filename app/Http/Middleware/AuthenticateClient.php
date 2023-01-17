<?php namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Response as Res;

class AuthenticateClient {

	protected $auth;

	public function __construct() {
		$this->auth = Auth::guard('client');
	}

	public function handle($request, Closure $next)	{
		if ($this->auth->guest()) {
			// AJAX REQUEST
			if($request->ajax()) {
				$data = [];
				$data['type'] = 'error';
				$data['caption'] = 'Unauthorized access.';
				$data['redirectUrl'] = url('/login');
				return response()->json($data);
			}
			// NON AJAX REQUEST
			else {
				return redirect()->guest('/login');
			}

		}
		return $next($request);
	}

}
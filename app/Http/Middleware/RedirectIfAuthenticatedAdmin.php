<?php namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticatedAdmin {

	protected $auth;
	

	public function __construct() {
		$this->auth = Auth::guard('admin');
	}

	public function handle($request, Closure $next)	{
		if ($this->auth->check()) {
			if($request->ajax()) {
				$data = [];
				$data['type'] = 'success';
				$data['redirectUrl'] = url('/manage/login');
				return response()->json($data);
			}
			else {
				return new RedirectResponse(url('/manage/login'));
			}
		}
		return $next($request);
	}

}
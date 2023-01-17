<?php namespace App\Http\Middleware;

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Response as Res;
use Response;
use App\Apilog;

class GetUserFromToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    // protected $events;
    // protected $auth;


    // public function __construct(Dispatcher $events)
    // {
    //     $this->events = $events;
    //     $this->auth = auth('api');
    // }


    public function handle($request, \Closure $next)
    {
        // dd($this->auth->setRequest($request)->getToken());
        // token_not_provided
        if(!$token = $this->auth->setRequest($request)->getToken()) {

            $data = [];
            // $data['errorcode'] = 1001;
            // $data['message'] = config('api.api_errors')[$data['errorcode']]['message'];
            $data['message'] = getTranslation('Token not found.');
            return send_api_response($request, $data, Res::HTTP_UNAUTHORIZED, []);

        }

        try {

            $user = $this->auth->authenticate($token);

        }
        // token black listed
        catch (TokenBlacklistedException $e) {

            $data = [];
            // $data['errorcode'] = 1005;
            // $data['message'] = config('api.api_errors')[$data['errorcode']]['message'];
            $data['message'] = getTranslation('Token blacklisted.');
            return send_api_response($request, $data, Res::HTTP_UNAUTHORIZED, []);

        }
        // token_expired
        catch (TokenExpiredException $e) {

            $data = [];
            // $data['errorcode'] = 1002;
            // $data['message'] = config('api.api_errors')[$data['errorcode']]['message'];
            $data['message'] = getTranslation('Token expired.');
            return send_api_response($request, $data, Res::HTTP_UNAUTHORIZED, []);

        }
        // token_invalid
        catch (JWTException $e) {

            $data = [];
            // $data['errorcode'] = 1003;
            // $data['message'] = config('api.api_errors')[$data['errorcode']]['message'];
            $data['message'] = getTranslation('Token is invalid.');
            return send_api_response($request, $data, Res::HTTP_UNAUTHORIZED, []);

        }
        // user_not_found
        if (!$user) {

            $data = [];
            // $data['errorcode'] = 1004;
            // $data['message'] = config('api.api_errors')[$data['errorcode']]['message'];
            $data['message'] = getTranslation('User not found.');
            return send_api_response($request, $data, Res::HTTP_NOT_FOUND, []);

        }
        else {

            if($user->status == 0) {

                $data = [];
                // $data['errorcode'] = 1023;
                // $data['message'] = config('api.api_errors')[$data['errorcode']]['message'];
                $data['message'] = getTranslation('Your account has been deactivated.');
                return send_api_response($request, $data, Res::HTTP_UNAUTHORIZED, []);

            }
            // else if($user->status == 2) {

            //     $data = [];
            //     $data['errorcode'] = 1024;
            //     $data['message'] = config('api.api_errors')[$data['errorcode']]['message'];
            //     return send_api_response($request, $data, Res::HTTP_UNAUTHORIZED, []);

            // }

        }

        // $this->events->dispatch('tymon.jwt.valid', $user);

        return $next($request);
    }
}

<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Libraries\Api\Frontapi\Api;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use View;

class BaseController extends Controller {

	protected $globaldata = [];

    public function __construct() {

        // SET LOCALE FOR CURRENT LANGUAGE
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        else { 
            // This is optional as Laravel will automatically set the fallback language if there is none specified
            App::setLocale(Config::get('app.fallback_locale'));
        }

        if(!empty(Session::get('user'))) {
            $user 						= Session::get('user');
            $this->globaldata['user'] 	= $user;
        }


    	View::share('globaldata', $this->globaldata);
    }


}
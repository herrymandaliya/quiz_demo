<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Libraries\Api\Frontapi\Api;

class HomeController extends BaseController {

    public function index() {
    	$data = [];
    	return view_front('home', $data);
    }



}

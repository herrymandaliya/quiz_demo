<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Verifyotp;
use Illuminate\Support\Facades\Hash;
use Log;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends BaseController
{

    public function index() {
    	return view_front('dashboard');
    }
}

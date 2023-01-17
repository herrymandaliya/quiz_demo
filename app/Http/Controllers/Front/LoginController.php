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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends BaseController
{

    public function index() {
    	return view_front('login');
    }


    public function submit(Request $request)
    {

        // if ajax request
        if ($request->ajax()) {

            $rules = [
                'login'    => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';
                $data['errorfields'] = $validator->errors()->keys();
            } else {

                $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
                    ? 'email'
                    : 'mobile_no';

                // $request->merge([
                //     $login_type => $request->input('login')
                // ]);


                $password = $request->password;
                $remember = 0;
                if ($request->remember) {
                    $remember = 1;
                }

                if(Auth::validate([$login_type => $request->input('login'), 'password' => $password, 'isAdmin' => 1])){
                    if(Auth::attempt([$login_type => $request->input('login'), 'password' => $password, 'status' => 1], $remember)) {
                        $data['type'] = 'success';
                        $data['redirectUrl'] = url('/dashboard');
                    }
                    else {

                      $user = User::where('email', $request->input('login'))->orWhere('mobile_no', $request->input('login'))->first();
                      
                      // dd($user);

                        $otp = rand(1000,9999);
                        Log::info("otp = ".$otp);
                        $varifyotp = New Verifyotp();
                        $varifyotp->user_id             = $user->user_id;
                        $varifyotp->otp                 = $otp;
                        $varifyotp->expire_at           = Carbon::now()->addMinutes(10);
                        $verify_otp =  $varifyotp->save();
                      
                        if($verify_otp){
                
                        Mail::raw('Your OTP is : '. $otp, function ($message)  {
                          $message->to('hirenm.albiorix@gmail.com')->subject('Please Verify yore Email Using this Otp')
                          ->from('bhavdeep.albiorix@gmail.com', 'Hiren');
                        });
                        
                        $encypr_userid = Crypt::encrypt($user->user_id);
                        
                        $data["type"] = "success";
                        $data['caption'] ="Otp sent successfully in your Email";
                        $data['redirectUrl'] = url('otp-verify/'.$encypr_userid);
                        }
                        else{
                            $data['type'] = 'error';
                            $data['caption'] = $captionerror;
                        }
                        $data['type'] = 'success';
                        $data['caption'] = 'Please verify your email address to login.';
                    }
                }
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'Your member name/Email, or Password is incorrect; please try again!';
                }
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect('/login');
    }
}

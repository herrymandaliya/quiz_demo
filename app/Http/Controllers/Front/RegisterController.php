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

class RegisterController extends BaseController
{

    public function index() {


    	return view_front('register');
    }

    public function submit(Request $request){
        // if ajax request
        // dd($request->ajax());
        if($request->ajax()) {
        	$email = trim($request->email);
            $rules = array(
	              'name'                  => 'required',
                'email'                 => 'required|email',
                'phone_no'              => 'required',
                'password'              => 'required|confirmed',
                'password_confirmation' => 'required'
	        );

	        $validator 	= Validator::make($request->all(), $rules);

	        $validator->after(function($validator) use ($email) {
	        	// check provided email availability
	        	$res 	= User::where('email', $email)->get();
           
	        	if(count($res) > 0) {
	        		$validator->errors()->add('email', 'Email is already in use. Please try different email.');
	        	}
	        });
	        // if validation fails
    		if ($validator->fails()) {
    			$data['type'] = 'error';
    			$data['caption'] = 'One or more invalid input found.';
    			$data['errorfields'] = $validator->errors()->keys();
    			$data['errormessage'] = $validator->errors()->all();
    		}
    		// if validation success
    		else {
                $user = New User();
                $user->name             = $request->name;
                $user->email            = $request->email;
                $user->isAdmin          = 1;
                $user->status           = 0;
                $user->mobile_no          = $request->phone_no;
                $password               = $request->password;
                $user->password         = Hash::make($password);
                $result = $user->save();
        
                $captionsuccess = 'User registered successfully.';
                $captionerror = 'Unable register user. Please try again.';

    			// database insert/update success
    			if($result) {

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
            $data['caption'] = "$captionsuccess";
            $data['redirectUrl'] = url('otp-verify/'.$encypr_userid);
            }
            else{
               	$data['type'] = 'error';
    				    $data['caption'] = $captionerror;
            }
    			}
    			// database insert/update fail
    			else {
    				$data['type'] = 'error';
    				$data['caption'] = $captionerror;
    			}     
    		}
            return response()->json($data);
        }
        else {
            return 'No direct access allowed!';
        }
    }

    function otpverify($id){
      
      $data['id'] = $id;

      return view_front('otp-verify',$data);
    }

    function otpverifysubmit(Request $request){
      if($request->ajax()) {
        $rules = array(
          'otpverify'                  => 'required', 
        );
        $captionsuccess = 'You are successfully verified.';
        $captionerror = 'Your Otp is invalid.';
        $id = Crypt::decrypt($request->user_id);
        $otp = $request->otpverify;

        $checkOtp = Verifyotp::where('user_id', $id)->where('otp', $otp)->first();

        if ($checkOtp) {

          $updateotp = User::find($id);
          if(!empty($updateotp)) {
            $updateotp->status   = 1;
            $updateotp->update();
        }

        $data["type"] = "success";
        $data['caption'] = $captionsuccess;
        $data['redirectUrl'] = url('login');

        }else{
          $data['type'] = 'error';
    			$data['caption'] = $captionerror;
          
        }
         return response()->json($data);
      }else{
        return 'No direct access allowed!';
      }
      
    }
}

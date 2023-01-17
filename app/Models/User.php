<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $table        = 'users';

    protected $primaryKey   = 'user_id';

    protected $hidden       = [
        'password',
        'remember_token'
    ];

    protected $appends      = [
        'userdir',
        'imagefilepath',
        'hasimage',
        'statustext',
        'designationname',
        'fullname'
    ];

    /*----------SETTER GETTER START----------*/
    public function getUserdirAttribute() {
        return config('constants.path_user') . intval($this->user_id) . '/';

    }

    public function getImagefilepathAttribute() {
        $imagefile = trim($this->imagefile);
        $user_id = intval($this->user_id);
        if(file_exists(public_path() . config('constants.path_user') . $user_id . '/' . $imagefile) && $imagefile != '') {
            return asset(config('constants.path_user') . $user_id . '/' . $imagefile);
        }
        else {
            return asset('images/no-images/user.png');
        }
    }

    public function getHasimageAttribute() {
        $imagefile = trim($this->imagefile);
        $user_id = intval($this->user_id);
        if(file_exists(public_path() . config('constants.path_user') . $user_id . '/' . $imagefile) && $imagefile != '') {
            return true;
        }
        return false;
    }

    public function getStatustextAttribute() {
        if($this->status == 1) {
            return '<span class="badge bg-inverse-success">Yes</span>';
        }
        else {
            return '<span class="badge bg-inverse-danger">No</span>';
        }
    }
    public function getDesignationnameAttribute() {
        if(!empty($this->designation)) {
            return $this->designation->name;
        }
        else {
            return '';
        }
    }

    public function getFullnameAttribute() {
        return $this->firstname.' '.$this->lastname;
    }
    /*----------SETTER GETTER END----------*/


    /*----------RELATION FUNCTIONS START----------*/
    public function designation() {
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }
    /*----------RELATION FUNCTIONS START----------*/



    /*----------SOCPE FUNCTIONS START----------*/
    public function scopeSearch($query, $value) {
        if(!empty(trim($value))) {
            $value = trim($value);
            $query->where('users.email', 'LIKE', '%'.$value.'%')
                  ->orWhere('users.firstname', 'LIKE', '%'.$value.'%')
                  ->orWhere('users.lastname', 'LIKE', '%'.$value.'%')
                  ->orWhere('users.phoneno', 'LIKE', '%'.$value.'%')
                  ->orWhere('users.address', 'LIKE', '%'.$value.'%');
        }
        return $query;
    }

    public function scopeAdminuser($query){
        return $query->Where('usertype', 1);
    }

    public function scopeMembers($query){
        return $query->Where('usertype', 2);
    }

    public function scopeClient($query){
        return $query->Where('usertype', 3);
    }

    public function scopeNotsuperadmin($query){
        return $query->where('issuperadmin', 0);
    }

    public function scopeAdmin($query) {
        return $query->where('users.usertype', 1);
    }

    public function scopeActive($query) {
        return $query->where('users.status', 1);
    }
    /*----------SOCPE FUNCTIONS END----------*/


}
<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Manage\AdminbaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientsController extends AdminbaseController
{
    public function index() {
    	$data = ['menu_client' => true];

        return view_admin('clients.clients', $data);
    }

    public function load(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $data['clients'] = User::where('usertype',3)->paginate(config('constants.perpage'));
            return view_admin('ajax.projects.projects', $data);

        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

}

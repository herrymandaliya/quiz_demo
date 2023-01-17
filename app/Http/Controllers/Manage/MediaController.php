<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Manage\AdminbaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Projectmedia;
use App\Models\Projectmember;

class MediaController extends AdminbaseController
{
    public function index() {
    	$data = ['menu_media' => true];

        return view_admin('media.media', $data);
    }

    public function load(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $projects = Project::latest('project_id')->paginate(config('constants.perpage'));
            $data['projects'] = $projects;
            return view_admin('ajax.media.media', $data);

        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function view($id) {

        $project = Project::find($id);
        if(!empty($project)) {
            $data = ['menu_media' => true];
            $data['project'] = $project;

            return view_admin('media.view', $data);
        }
        else {
            return abort('404');
        }
    }

    public function download($id){
        $project_media = Projectmedia::find($id);
        
        if(!empty($project_media)) {
            if($project_media->hasmedia){
                return response()->download($project_media->publicmediafilepath);    
            }
            else {
                return abort('404');
            }
        }
        else {
            return abort('404');
        }
    }

}

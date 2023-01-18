<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Manage\AdminbaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Project;
use App\Models\Projectmember;
use App\Models\User;
use App\Models\Projectmessage;
use App\Models\Projectmedia;
use Auth;

class ProjectController extends AdminbaseController
{
    public function index() {
    	$data = ['menu_projects' => true];

        return view_admin('projects.projects', $data);
    }

    /* admin list data through ajax  */
    public function load(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $projects = Project::latest('project_id')->paginate(config('constants.perpage'));
            $data['projects'] = $projects;
            return view_admin('ajax.projects.projects', $data);

        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function create() {
        $data = ['menu_projects' => true];
        $project = new Project();
        $data['project'] = $project;

        $clients = User::active()->client()->get()->pluck('fullname','user_id')->toArray();
        $data['clients'] = $clients;

        $teammembers = User::active()->members()
                        ->leftjoin('designations', 'designations.designation_id','=','users.designation_id')
                        ->Where(function($query) {
                            $query->where('designations.isprojectmanager', 0);
                        })
                        ->get();
        $data['teammembers'] = $teammembers;

        $projectmanagers = User::active()->members()
                        ->leftjoin('designations', 'designations.designation_id','=','users.designation_id')
                        ->Where(function($query) {
                            $query->where('designations.isprojectmanager', 1);
                        })
                        ->get()->pluck('fullname','user_id')->toArray();

        $data['projectmanagers'] = $projectmanagers;

        $addedteammembers = collect();
        $data['addedteammembers'] = $addedteammembers;

        return view_admin('projects.project', $data);
    }

    /* project edit page */
    public function edit($id) {

        $project = Project::find($id);
        if(!empty($project)) {
            $data = ['menu_projects' => true];
            $data['project'] = $project;

            $clients = User::active()->client()->get()->pluck('fullname','user_id')->toArray();
            $data['clients'] = $clients;

            $teammembers = User::active()->members()
                            ->leftjoin('designations', 'designations.designation_id','=','users.designation_id')
                            ->Where(function($query) {
                                $query->where('designations.isprojectmanager', 0);
                            })
                            ->get();
            $data['teammembers'] = $teammembers;

            $projectmanagers = User::active()->members()
                        ->leftjoin('designations', 'designations.designation_id','=','users.designation_id')
                        ->Where(function($query) {
                            $query->where('designations.isprojectmanager', 1);
                        })
                        ->get()->pluck('fullname','user_id')->toArray();

            $data['projectmanagers'] = $projectmanagers;


            $addedteammembers = Projectmember::with('member')->where('project_id', $project->project_id)->get();
            $data['addedteammembers'] = $addedteammembers;


            return view_admin('projects.project', $data);
        }
        else {
            return abort('404');
        }

    }

    /* project edit page */
    public function view($id) {

        $project = Project::find($id);
        if(!empty($project)) {
            $data = ['menu_projects' => true];
            $data['project'] = $project;

            $clients = User::active()->client()->get()->pluck('fullname','user_id')->toArray();
            $data['clients'] = $clients;

            $teammembers = User::active()->members()
                            ->leftjoin('designations', 'designations.designation_id','=','users.designation_id')
                            ->Where(function($query) {
                                $query->where('designations.isprojectmanager', 0);
                            })
                            ->get();
            $data['teammembers'] = $teammembers;

            $projectmanagers = User::active()->members()
                        ->leftjoin('designations', 'designations.designation_id','=','users.designation_id')
                        ->Where(function($query) {
                            $query->where('designations.isprojectmanager', 1);
                        })
                        ->get()->pluck('fullname','user_id')->toArray();

            $data['projectmanagers'] = $projectmanagers;


            $addedteammembers = Projectmember::with('member')->where('project_id', $project->project_id)->get();
            $data['addedteammembers'] = $addedteammembers;


            return view_admin('projects.view', $data);
        }
        else {
            return abort('404');
        }

    }


    /* project add / update code */
    public function store(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $data = [];

            $project_id = intval($request->project_id);

            // make validation rules for received data
            $rules = [
                    'title'         => 'required',
                    'start_date'    => 'required',
                    'end_date'      => 'required',
                    'client_id'     => 'required',
                    'priority'      => 'required',
                    'manager_id'    => 'required'
            ];

            $project = ($project_id == 0) ? new Project() : Project::find($project_id);

            // validate received data
            $validator = Validator::make($request->all(), $rules);


            // if validation fails
            if ($validator->fails()) {
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';
                $data['errorfields'] = $validator->errors()->keys();
                $data['errormessage'] = $validator->errors()->all();
            }
            // if validation success
            else {

                $project->title         = trim($request->title);
                $project->client_id     = intval($request->client_id);
                $project->start_date    = trim($request->start_date);
                $project->end_date      = trim($request->end_date);
                $project->priority      = intval($request->priority);
                $project->manager_id    = intval($request->manager_id);
                $project->description   = trim($request->description);

                // add
                if($project_id == 0) {
                    $result = $project->save();
                    $captionsuccess = 'Project added successfully.';
                    $captionerror = 'Unable add project. Please try again.';

                    if(isset($request->teammemberid) && count($request->teammemberid) > 0) {
                        for ($i=0; $i < count($request->teammemberid); $i++) {

                            $projectmember = new Projectmember();
                            $projectmember->user_id             = $request->teammemberid[$i];
                            $projectmember->project_id          = 1;
                            $projectmember->haschatpermission   = $request->chatpermission[$i];
                            $projectmember->save();
                        }
                    }
                }
                // edit
                else {
                    $result = $project->update();
                    $captionsuccess = 'Project updated successfully.';
                    $captionerror = 'Unable update project. Please try again.';

                    $existing_projectmember = Projectmember::where('project_id', 1)->get();
                    $existing_projectmember_arr = $existing_projectmember->pluck('user_id')->toArray();

                    if(isset($request->teammemberid) && count($request->teammemberid) > 0) {
                        for ($i=0; $i < count($request->teammemberid); $i++) {

                            if (in_array($request->teammemberid[$i], $existing_projectmember_arr)) {
                                $projectmemberupdate = Projectmember::where('project_id', 1)->where('user_id', $request->teammemberid[$i])->first();
                                if(!empty($projectmemberupdate)) {
                                    $projectmemberupdate->haschatpermission   = $request->chatpermission[$i];
                                    $projectmemberupdate->save();
                                }
                            }
                            else {
                                $projectmember = new Projectmember();
                                $projectmember->user_id             = $request->teammemberid[$i];
                                $projectmember->project_id          = 1;
                                $projectmember->haschatpermission   = $request->chatpermission[$i];
                                $projectmember->save();
                            }

                            array_splice($existing_projectmember_arr, array_search(22, $existing_projectmember_arr ), 1);
                        }
                    }

                    if(!empty($existing_projectmember_arr)) {
                        foreach ($existing_projectmember_arr as $key => $value) {
                            $projectmemberdelete = Projectmember::where('project_id', 1)->where('user_id', $value)->delete();
                        }
                    }
                }


                // database insert/update success
                if($result) {
                    $data["type"] = "success";
                    $data['caption'] = $captionsuccess;
                    $data['redirectUrl'] = url('/manage/projects');
                }
                // database insert/update fail
                else {
                    $data['type'] = 'error';
                    $data['caption'] = $captionerror;
                }
            }


            return response()->json($data);

        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }


    /* user delete */
    public function destroy(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $data = [];

            $user = User::frontuser()->notsuperadmin()->find($request->user_id);
            if(!empty($user)) {

                $userdir = public_path($user->userdir);
                $files_deleted = true;

                // delete old image file if any
                if($user->hasimage) {
                    if(!File::deleteDirectory($userdir)) {
                        $files_deleted = false;
                    }
                }

                // if physical files deleted then delete entry from database
                if($files_deleted) {
                    if($user->delete()) {
                        $data['type'] = 'success';
                        $data['caption'] = 'User deleted successfully.';
                    }
                    else {
                        $data['type'] = 'error';
                        $data['caption'] = 'Unable to delete user.';
                    }
                }
                // physical files not deleted
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'Unable to delete user.';
                }
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Invalid user.';
            }

            return response()->json($data);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function getmessages(Request $request) {
        // if ajax request

        if ($request->ajax()) {
            $data = [];
            $project_id = intval($request->project_id);
            //GET VISIT DATA BY VISITID
            $project = Project::find($project_id);
            if(!empty($project)) {
                // GET ALL VISIT MESSAGES
                $data['projectmessages'] = $project->messages()->orderBy("projectmessages.projectmessage_id",'asc')->get();
                // GET ALL UNREAD MESSAGE AND MARK AS READ
                $messages = Projectmessage::where('project_id', $project_id)->where('readstatus', 0)->get();
                if(isset(auth('admin')->user()->user_id)){
                    $data['auth'] = auth('admin')->user()->user_id;
                }else if(isset(auth('member')->user()->user_id)){
                    $data['auth'] = auth('member')->user()->user_id;
                }else{
                    $data['auth']= auth('client')->user()->user_id;
                }

                // if(isset($messages) && count($messages) > 0) {
                //     foreach($messages as $row)
                //     {
                //         if($this->isEditor()) {
                //             if($row->fromuser->usertype == 2 || $row->fromuser->usertype == 1){
                //                 $row->readstatus=1;
                //                 $row->save();
                //             }
                //         }
                //         else {
                //             if($row->fromuser->usertype == 2 || $row->fromuser->usertype == 3){
                //                 $row->readstatus=1;
                //                 $row->save();
                //             }
                //         }

                //     }
                // }
            }

            return  view_admin('ajax.projects.projectmessages', $data);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function getmessage(Request $request) {
        // if ajax request

        if ($request->ajax()) {
            $data = [];
            $projectmessage_id = intval($request->projectmessage_id);
            $data['projectmessage'] = Projectmessage::find($projectmessage_id);

            return  view_admin('ajax.projects.projectmessage', $data);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function sendmessage(Request $request) {
        // if ajax request
        
        if ($request->ajax()) {
            $data = [];

            $admin          = $this->globaldata['admin'];
            $fromid         = $admin->user_id;
            $project_id     = intval($request->project_id);
            $message        = trim($request->message);

            // make validation rules for received data
            $rules = [];

            if (!$request->media) {
                $rules['message'] = 'required';
            }

            $projectmessage = new Projectmessage();

            // validate received data
            $validator = Validator::make($request->all(), $rules);

            // if validation fails
            if ($validator->fails()) {
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';

                $data['errorfields'] = $validator->errors()->keys();
                $data['errormessage'] = $validator->errors()->all()[0];
            }
            // if validation success
            else {
                $projectmessage->project_id        = $project_id;
                $projectmessage->from_id           = $fromid;
                $projectmessage->message           = $message;
                $projectmessage->readstatus        = 0;
                $projectmessage->status            = 1;

                $result = $projectmessage->save();
                $captionsuccess             = 'Message send successfully.';
                $captionerror               = 'Unable send message. Please try again.';
                $activitylogdescription[]   = 'Message saved';

                // database insert/update success
                if($result) {

                    $messagesdata = Projectmessage::where('project_id', $project_id)
                    // ->where('fromid',$toid)
                    ->where('readstatus', 0)->get();

                    if(isset($messagesdata) && count($messagesdata) > 0) {
                        foreach($messagesdata as $row)
                        {
                            $row->readstatus=1;
                            $row->save();
                        }
                    }

                    // if success
                    $data['type']               = 'success';
                    $data['caption']            = $captionsuccess;
                    $data['projectmessage_id']  = $projectmessage->projectmessage_id;
                }
                // database insert/update fail
                else {
                    $data['type'] = 'error';
                    $data['caption'] = $captionerror;
                }
            }

        return response()->json($data);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function sendmediamessage(Request $request) {
        // if ajax request
        // dd($request);
        if ($request->ajax()) {
            $data = [];

            $projectmessage_id     = intval($request->projectmessage_id);

            // make validation rules for received data
            $rules = array(
                // 'message'   => 'required'
            );

            $projectmedia = new Projectmedia();

            // validate received data
            $validator = Validator::make($request->all(), $rules);

            // if validation fails
            if ($validator->fails()) {
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';

                $data['errorfields'] = $validator->errors()->keys();
                $data['errormessage'] = $validator->errors()->all()[0];
            }
            // if validation success
            else {
                $projectmessage = Projectmessage::find($projectmessage_id);
                if(!empty($projectmessage)) {
                    
                    $projectmedia->project_id        = $projectmessage->project_id;
                    $projectmedia->projectmessage_id = $projectmessage->projectmessage_id;
                    
                    $result = $projectmedia->save();

                    $captionsuccess             = 'Media saved successfully.';
                    $captionerror               = 'Unable save media. Please try again.';


                    // database insert/update success
                    if($result) {

                        $data["type"] = "error";

                        // upload image file if exist
                        if ($request->hasFile('file')) {

                            $filepath = public_path($projectmedia->mediadir);
                            if($request->file('file')->isValid()) {
                                $file       = $request->file('file');
                                $extension  = $file->getClientOriginalExtension();
                                $pathinfo   = pathinfo($file->getClientOriginalName());
                                $basename   = $pathinfo['basename'];
                                $filename   = $pathinfo['filename'];
                                $filesize   = $file->getSize();
                                
                                $filecreated = File::makeDirectory($filepath, 0777, true, true);
                                if($filecreated) {
                                    if($request->file('file')->move($filepath, $basename)) {
                                        $projectmedia->media_name   = $filename;
                                        $projectmedia->media_file   = $basename;
                                        $projectmedia->media_size   = $filesize;
                                        $projectmedia->media_ext    = $extension;
                                        $projectmedia->update();
                                        $data["type"] = "success";
                                    }
                                    else {
                                        $data['caption'] = $captionsuccess. ' But unable to upload file.';
                                    }
                                }
                                else {
                                    $data['caption'] = $captionsuccess. ' But unable to upload file.';
                                }
                            }
                            else {
                                $data['caption'] = $captionsuccess. ' But invalid file uploaded.';
                            }
                        }
                        // if no file uploaded
                        else {
                            $data["type"] = "success";
                        }


                        if($data["type"] == 'success') {
                            $data['caption'] = $captionsuccess;
                            $data['filepath'] = $projectmedia->mediafilepath;
                        }


                        // if success
                        $data['type']               = 'success';
                        $data['caption']            = $captionsuccess;
                    }
                    // database insert/update fail
                    else {
                        $data['type']       = 'error';
                        $data['caption']    = $captionerror;
                    }
                }
                else {
                    $data['type']       = 'error';
                    $data['caption']    = "Unable to find message.";
                }
            }

        return response()->json($data);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

}

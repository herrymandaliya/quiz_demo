<?php namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Manage\AdminbaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Designation;

class DesignationController extends AdminbaseController {

	public function index() {
		$data = [];
		$data['menu_designations'] = true;

		return view_admin('designations.designations', $data);
	}

    public function create() {
        $data = ['menu_designations' => true];
        $designation = new Designation();
        $data['designation'] = $designation;

        return view_admin('designations.designation', $data);
    }

    public function load(Request $request) {
    	// if ajax request
    	if ($request->ajax()) {

    		$designation = Designation::latest('designation_id')->paginate(config('constants.perpage'));
			$data['designation'] = $designation;
    		return view_admin('ajax.designations.designations', $data);

    	}
		// if non ajax request
		else {
			return 'No direct access allowed!';
		}
    }

    /* designation add / update code */
    public function store(Request $request) {
    	// if ajax request
    	if ($request->ajax()) {
            // dd($request);
    		$data = [];

    		$designation_id = intval($request->designation_id);

    		// make validation rules for received data
    		$rules = [
    				'name'	    => 'required',
    		];

            $designation = ($designation_id == 0) ? new Designation() : Designation::find($designation_id);

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

                $designation->name    = $request->name;
                $designation->status  = intval($request->status);

                // add
                if($designation_id == 0) {
                    $result = $designation->save();
                    $captionsuccess = 'Designation added successfully.';
                    $captionerror = 'Unable add designation. Please try again.';

    			}
    			// edit
    			else {
    				$result = $designation->update();
    				$captionsuccess = 'Designation updated successfully.';
    				$captionerror = 'Unable update designation. Please try again.';
    			}


    			// database insert/update success
    			if($result) {
                    $data['type'] = 'success';
                    $data['caption'] = $captionsuccess;
                    $data['redirectUrl'] = url('/manage/designations');

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

    /* designation edit page */
    public function edit($id) {
    	$designation = Designation::find($id);
    	if(!empty($designation)) {
    		$data = ['menu_designations' => true];
            $data['designation'] = $designation;

            return view_admin('designations.designation', $data);
    	}
    	else {
    		return abort('404');
    	}

    }

    public function destroy(Request $request) {
        // if ajax request
        if ($request->ajax()) {
            $data = [];
            $designation = Designation::find($request->designation_id   );
            if(!empty($designation)) {
                if($designation->delete()) {
                    $data['type'] = 'success';
                    $data['caption'] = 'Designation deleted successfully.';
                }
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'Unable to delete designation.';
                }

            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Invalid designation.';
            }

            return response()->json($data);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

}

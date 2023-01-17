<?php namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Manage\AdminbaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Models\Category;

class CategoryController extends AdminbaseController {

	public function index() {
		$data = [];
		$data['menu_categories'] = true;

		return view_admin('categories.categories', $data);
	}

    public function create() {
        $data = ['menu_categories' => true];
        $category = new Category();
        $data['category'] = $category;

        return view_admin('categories.category', $data);
    }

    public function load(Request $request) {
    	// if ajax request
    	if ($request->ajax()) {

    		$categories = Category::latest('category_id')->paginate(config('constants.perpage'));
			$data['categories'] = $categories;
    		return view_admin('ajax.categories.categories', $data);

    	}
		// if non ajax request
		else {
			return 'No direct access allowed!';
		}
    }

    /* category add / update code */
    public function store(Request $request) {
    	// if ajax request
    	if ($request->ajax()) {
            // dd($request);
    		$data = [];

    		$category_id = intval($request->category_id);

    		// make validation rules for received data
    		$rules = [
    				'name'	    => 'required',
    		];

            $category = ($category_id == 0) ? new Category() : Category::find($category_id);

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

                $category->name    = $request->name;
                $category->status  = intval($request->status);

                // add
                if($category_id == 0) {
                    $result = $category->save();
                    $captionsuccess = 'Category added successfully.';
                    $captionerror = 'Unable add category. Please try again.';

    			}
    			// edit
    			else {
    				$result = $category->update();
    				$captionsuccess = 'Category updated successfully.';
    				$captionerror = 'Unable update category. Please try again.';
    			}


    			// database insert/update success
    			if($result) {
                    $data["type"] = "error";

                    $imgpath = public_path($category->categorydir);

                    // delete image if set to true
                    if(intval($request->deleteimage) == 1) {

                        // delete old image file if any
                        if($category->hasimage) {
                            File::deleteDirectory($imgpath);
                        }

                        $category->imagefile = '';
                        $category->update();
                    }

                    // upload image file if exist
                    if ($request->hasFile('imagefile')) {
                        if($request->file('imagefile')->isValid()) {
                            $imagefile   = $request->file('imagefile');
                            $extension = $request->file('imagefile')->getClientOriginalExtension();
                            // delete old image file
                            File::deleteDirectory($imgpath);
                            $img = Image::make($imagefile);
                            $filecreated = File::makeDirectory($imgpath, 0777, true, true);
                            if($filecreated) {
                                $fileName = getTempName($imgpath, $extension);
                                if($img->save($imgpath . $fileName)) {
                                    $category->imagefile = $fileName;
                                    $category->update();
                                    $data["type"] = "success";
                                }
                                else {
                                    $data['caption'] = $captionsuccess. ' But unable to upload category image.';
                                }
                            }
                            else {
                                $data['caption'] = $captionsuccess. ' But unable to upload category image.';
                            }
                        }
                        else {
                            $data['caption'] = $captionsuccess. ' But invalid file uploaded.';
                        }
                    }
                    // if no image uploaded
                    else {
                        $data["type"] = "success";
                    }


                    if($data["type"] == 'success') {
                        $data['caption'] = $captionsuccess;
                        $data['redirectUrl'] = url('/manage/categories');
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
    	// if non ajax request
    	else {
    		return 'No direct access allowed!';
    	}
    }

    /* category edit page */
    public function edit($id) {
    	$category = Category::find($id);
    	if(!empty($category)) {
    		$data = ['menu_categories' => true];
            $data['category'] = $category;

            return view_admin('categories.category', $data);
    	}
    	else {
    		return abort('404');
    	}

    }

    public function destroy(Request $request) {
        // if ajax request
        if ($request->ajax()) {
            $data = [];
            $category = Category::find($request->category_id   );
            if(!empty($category)) {
                if($category->delete()) {
                    $data['type'] = 'success';
                    $data['caption'] = 'Category deleted successfully.';
                }
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'Unable to delete category.';
                }

            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Invalid category.';
            }

            return response()->json($data);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

}

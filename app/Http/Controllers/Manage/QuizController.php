<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Manage\AdminbaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Questionnaire;
use Auth;



class QuizController extends AdminbaseController
{
    public function index() {
    	//$data = ['menu_projects' => true];

        $data['quiz'] = Quiz::get();

        return view_admin('quiz.quizs',$data);
    }  

    public function create() {
    	//$data = ['menu_projects' => true];

        return view_admin('quiz.quiz');
    }  

    public function store(Request $request){
        $quiz_name = $request->input('q_name');
        // $class_code = $request->input('class_id');
        $exam_date = date('Y-m-d', strtotime($request->input('exam_date')));

        $questions = $request->input('question'); //Question
        
        $types = $request->input('qt'); //Question types

        $i = $request->input('i'); //Correct answer for identification
        $mc = $request->input('mc'); //Choices for multiple choice
        $c_mc = $request->input('c-mc'); //Correct choice
        $tf = $request->input('tf'); //Correct answer for true or false

        // $p = $request->input('points'); //Question point

        Quiz::create([
            'quizzes_name' => $quiz_name,
            'exam_date'=>$exam_date,
        ]);

        $q_id = Quiz::count(); //Questionnaire id.

        for($x = 0; $x < count($questions); $x++){
            $question = $questions[$x];
            $choices1 = ""; //For multiple choice use.
            $choices2 = ""; //For multiple choice use.
            $choices3 = ""; //For multiple choice use.
            $choices4 = ""; //For multiple choice use.
            $answer = null; //Obviously.
            // $points = $p[$x];
            if($types[$x] == 0){
                //ERROR
            }else if ($types[$x] == 1){//Identification
                $answer = $i[$x];
            }else if($types[$x] == 2){//Multiple choice
                $choices1 = $mc[$x][0];
                $choices2 = $mc[$x][1];
                $choices3 = $mc[$x][2];
                $choices4 = $mc[$x][3];
                $answer = $c_mc[$x];
            }else if($types[$x] == 3){//True or False
                $answer = $tf[$x];
            }
            // dd($choices1);
            if(trim($question) == "" || is_null($question))
                continue;
            
            Questionnaire::create([
                'quizze_id' => $q_id,
                'questionnaire_name' => $question,
                'questionnaire_type' => $types[$x],
                'choices1' => $choices1,
                'choices2' => $choices2,
                'choices3' => $choices3,
                'choices4' => $choices4,
                'answer' => $answer,
                // 'points' => $points
            ]);
        }

        // QuizEvent::create([
        //     'quiz_event_name' => $quiz_name,
        //     'questionnaire_id' => $q_id,
        //     'class_id' => $class_code,
        //     'quiz_event_status' => 0,
        // ]);

        return redirect('/manage/quiz');
    }

}

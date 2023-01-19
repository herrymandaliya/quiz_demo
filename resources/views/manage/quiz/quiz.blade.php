@extends('manage.layouts.admin')

@section('pagetitle', ' - Project')

@section('content')
<link href=
'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
          rel='stylesheet'>
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Quiz</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url_admin('quiz') }}">Quiz</a></li>
                <li class="breadcrumb-item active">{{ (empty($project)) ? 'Create' : 'Edit' }}</li>
            </ul>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0"></h4>
    </div>
    <div class="card-body">
        <div class="container">
            <h2>Create Quiz</h2>
                {!! Form::open(['url' => url_admin('quiz/store'),  'class' => '']) !!}
                {{ csrf_field() }}
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Quiz Name</label>
                        <input name="q_name" type="text" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="">Quiz Date</label>
                        <input name="exam_date" type="text" id="exam_date" class="form-control" required autofocus>
                    </div>
                    {{--<div class="form-group">
                        <label for="">Class</label>
                         <select name="class_id" id="class_id" class="form-control">
                            @foreach ($classes as $classe)
                            <option value="{{ $classe->class_id }}">{{ $classe->subject->subject_desc }} ({{ $classe->course_sec }})</option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>
        
                <div class="col-12" id="question">
                    <h3>Questions</h3>
                    <div class="row">
                        <div class="col-8">
                            <label for="">Question</label>
                            <textarea class="form-control"name="question[0]" id="question[0]" cols="30" rows="5" placeholder="Input question here..." required></textarea>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Question Type</label>
        
                                <select name="qt[0]" id="qt-0" class="form-control qt" required>
                                    <option value="">---Select a question type---</option>
                                    {{-- <option value="1">Identification</option> --}}
                                    <option value="2">Multiple Choice</option>
                                    <option value="3">True or False</option>
                                </select>
                            </div>
                            {{-- <div class="form-group form-inline">
                                <label for="" class="pr-2">Points:</label><input type="number" class="form-control" min="1" value="1" name="points[]" style="max-width: 100px">
                                
                            </div> --}}
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-block btn-sm ml-1" onclick="addQuestion()">Add Another Question</button>
                            </div>
                        </div>
                        
                        <div class="col-6" id="i-0" style="padding-top: 10px; display: none">
                            <label for="">Correct answer</label>
                            <input name="i[0]" type="text" class="form-control">
                        </div>
                        <div class="multiple-choice" id="mc-0" style="display: none">
                            <div class="col-12" style="padding-top: 10px;">
                                <div class="row">
                                    <div class="col-3"><label>Choice 1</label><input name="mc[0][0]" type="text" class="form-control"></div>
                                    <div class="col-3"><label>Choice 2</label><input name="mc[0][1]" type="text" class="form-control"></div>
                                    <div class="col-3"><label>Choice 3</label><input name="mc[0][2]" type="text" class="form-control"></div>
                                    <div class="col-3"><label>Choice 4</label><input name="mc[0][3]" type="text" class="form-control"></div>
                                </div>
                                <div class="row" style="padding-top: 10px;">
                                    <div class="col-8">
                                        <label for="">Correct choice</label>
                                        <select name="c-mc[0]" id="c-mc[0]" class="form-control">
                                            <option value="1">Choice 1</option>
                                            <option value="2">Choice 2</option>
                                            <option value="3">Choice 3</option>
                                            <option value="4">Choice 4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3" id="tf-0" style="padding-top: 10px;  display: none">
                            <label for="">Correct answer</label>
                            <select name="tf[0]" id="" class="form-control">
                                <option value="1">True</option>
                                <option value="0">False</option>
                            </select>
                        </div>
                        <script>
                            
                        </script>
                    </div>
                    <hr>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


@endsection


@section('page-scripts')
<script src="{{ asset_admin('js/quiz/quiz.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

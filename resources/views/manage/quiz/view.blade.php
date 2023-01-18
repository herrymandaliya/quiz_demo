@extends('manage.layouts.admin')

@section('pagetitle', ' - Project')

@section('page-css')
<style type="text/css">
    .input-group.form-group .error {
        position: absolute;
        bottom: -20px;
        left: 0;
    }
</style>
@endsection

@section('content')

<section class="container">
    <h1>Manage Quiz</h1>
    <b>
        <p>{{ $q->quizzes_name }}</p>
    </b>
    <hr>
    <div class="row">
        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="questions" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <h5>Questions</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Question Type</th>
                                <th>Choices</th>
                                <th>Controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{dd($q->question)}} --}}
                            @foreach($q->question as $qe)
                                <tr>
                                    <td>{{ $qe->questionnaire_name }}</td>
                                    <td>
                                        @if($qe->questionnaire_type == 2) Multiple choice
                                        @elseif($qe->questionnaire_type == 3) True or False 
                                        @else <b>Invalid Type</b>
                                        @endif
                                    </td>
                                    <td>
                                        <span>{{$qe->choices1}} </span><br>
                                        <span>{{$qe->choices2}} </span> <br>
                                        <span>{{$qe->choices3}} </span><br> 
                                        <span>{{$qe->choices4}}</span> 
                                       @php
                                            //$a = explode(';', $qe->choices1);
                                            //foreach ($a as $ch){ echo $ch . '<br>'; }
                                        @endphp
                                    </td>
                                    <td>
                                        {{-- {{dd($qe->choices4)}} --}}
                                        @if($qe->questionnaire_type == 2)
                                            <button class="btn btn-primary btn-sm" data-qid="{{ $qe->questionnaire_id }}" data-question="{{ $qe->questionnaire_name }}" data-question-type="{{ $qe->questionnaire_type }}"
                                                data-choices1="{{ $qe->choices1 }}" data-choices2="{{ $qe->choices2 }}" data-choices3="{{ $qe->choices3 }}" data-choices4="{{ $qe->choices4 }}" data-correct-ans="{{ $qe->answer }}" 
                                                data-toggle="modal" data-target="#editQuestion">Edit
                                            </button>
                                        @elseif($qe->questionnaire_type == 3)
                                            <button class="btn btn-primary btn-sm" data-qid="{{ $qe->questionnaire_id }}" data-question="{{ $qe->questionnaire_name }}" data-question-type="{{ $qe->questionnaire_type }}"
                                                data-choices1="{{ $qe->choices1 }}" data-choices2="{{ $qe->choices2 }}" data-choices3="{{ $qe->choices3 }}" data-choices4="{{ $qe->choices4 }}" data-correct-ans="{{ $qe->answer }}" data-toggle="modal"
                                                data-target="#editQuestion">Edit
                                            </button>
                                        @endif
                                        <button class="btn btn-primary btn-sm btn-danger" data-qid="{{ $qe->question_id }}" data-toggle="modal" data-target="#deleteQuestion">Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createQuestion">Add new question</button>
                </div>
                <div class="tab-pane fade " id="basic-info" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, inventore.
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                <a class="nav-link active" id="questions-tab" data-toggle="pill" href="#questions" role="tab" aria-controls="v-pills-profile" aria-expanded="true">Questions</a>
                {{--  <a class="nav-link" id="basic-info-tab" data-toggle="pill" href="#basic-info" role="tab" aria-controls="v-pills-home"
                    aria-expanded="true">Basic Information</a>  --}}
            </div>
        </div>


    </div>

</section>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestion" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Question</label>
                    <textarea id="question" id="" cols="30" rows="3" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Type</label>
                    <select name="" id="opt" class="form-control" required>
                        <option value="2">Multiple Choice</option>
                        <option value="3">True or False</option>
                    </select>
                </div>
                <div id="f-multiple-choice" style="display: none;">
                    <div class="form-group form-inline">
                        <input type="text" id="mc0" name="mc[]" class="form-control col-5 mr-auto" placeholder="Choice 1">
                        <input type="text" id="mc1" name="mc[]" class="form-control col-5 ml-auto" placeholder="Choice 2">
                    </div>
                    <div class="form-group form-inline">
                        <input type="text" id="mc2" name="mc[]" class="form-control col-5 mr-auto" placeholder="Choice 3">
                        <input type="text" id="mc3" name="mc[]" class="form-control col-5 ml-auto" placeholder="Choice 4">
                    </div>
                </div>

                <div class="form-group" id="cf-identify" style="display: none">
                    <label for="">Correct answer</label>
                    <input type="text" class="form-control" id="c-identify" name="c-identify" placeholder="Correct answer here...">
                </div>

                <div class="form-group" id="cf-tf" style="display: none">
                    <label for="">Correct choice</label>
                    <select id="c-tf" class="form-control" name="c-tf">
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>

                <div class="form-group" id="cf-mc" style="display: none">
                    <label for="">Correct choice</label>
                    <select name="c-mc" id="c-mc" class="form-control">
                        <option value="1">Choice 1</option>
                        <option value="2">Choice 2</option>
                        <option value="3">Choice 3</option>
                        <option value="4">Choice 4</option>
                    </select>
                </div>
                <input type="hidden" id="_qid" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="UpdateQuestion()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Question Modal -->
<div class="modal fade" id="createQuestion" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Question</label>
                    <textarea id="a_question" id="" cols="30" rows="3" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Type</label>
                    <select name="" id="a_opt" class="form-control" required>
                        <option value="2">Multiple Choice</option>
                        <option value="3">True or False</option>
                    </select>
                </div>
                <div id="a_f-multiple-choice" style="display: none;">
                    <div class="form-group form-inline">
                        <input type="text" id="a_mc0" name="mc[]" class="form-control col-5 mr-auto" placeholder="Choice 1">
                        <input type="text" id="a_mc1" name="mc[]" class="form-control col-5 ml-auto" placeholder="Choice 2">
                    </div>
                    <div class="form-group form-inline">
                        <input type="text" id="a_mc2" name="mc[]" class="form-control col-5 mr-auto" placeholder="Choice 3">
                        <input type="text" id="a_mc3" name="mc[]" class="form-control col-5 ml-auto" placeholder="Choice 4">
                    </div>
                </div>

                <div class="form-group" id="a_cf-identify" style="display: none">
                    <label for="">Correct answer</label>
                    <input type="text" class="form-control" id="c-identify" name="c-identify" placeholder="Correct answer here...">
                </div>

                <div class="form-group" id="a_cf-tf" style="display: none">
                    <label for="">Correct choice</label>
                    <select id="c-tf" class="form-control" name="c-tf">
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>

                <div class="form-group" id="a_cf-mc" style="display: none">
                    <label for="">Correct choice</label>
                    <select name="c-mc" id="c-mc" class="form-control">
                        <option value="1">Choice 1</option>
                        <option value="2">Choice 2</option>
                        <option value="3">Choice 3</option>
                        <option value="4">Choice 4</option>
                    </select>
                </div>
                <input type="hidden" id="a_qid" value="{{ $q->quizze_id }}">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="AddQuestion()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Question Confirmation Modal -->
<div class="modal fade" id="deleteQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm deletion of question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this question? This is irreversible!
                <input type="hidden" id="q_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="DeleteQuestion()">Delete Question</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('page-scripts')
<script src="{{ asset_admin('js/quiz/view.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

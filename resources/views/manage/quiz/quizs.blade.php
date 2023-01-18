@extends('manage.layouts.admin')

@section('pagetitle', ' - Projects')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Quiz</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Quiz</li>
                </ul>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="{{ url_admin('quiz/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Project</a>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table">
                    <thead>
                        <tr>
                            <th>Quiz Name</th>
                            <th>Exam Date</th>
                            <th >Action</th>
                        </tr>
                    </thead>
                   
                    <tbody id="tabledata">
                        @foreach($quiz as $quizs)
                        
                        <tr>
                            <td >{{$quizs->quizzes_name}}</td>
                            <td>{{$quizs->exam_date}}</td>    
                            <td ><a class="edit" href="{{url_admin('quiz/edit/' .$quizs->quizze_id)}}"><i class="fa fa-edit"></i></a><a class="remove" onclick="return confirm('Are you sure delete this item?')" href="#"><i class="fa fa-trash"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-right" id="pagingdata" style="display: none;"></div>
        </div>
    </div>
   


@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/quiz/quizs.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection
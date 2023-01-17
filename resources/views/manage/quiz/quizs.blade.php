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
    {{-- <div class="filter-row">
        {!! Form::open(['url' => url_admin('quiz/load'), 'id' => 'searchform', 'class' => '']) !!}
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group form-focus">
                        <input class="form-control floating" name="search" title="Search by project name" id="searchtextbox" data-toggle="tooltip">
                        <label class="focus-label">Search text</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating">
                            <option>Select Status</option>
                            <option>New</option>
                            <option>Active</option>
                            <option>On hold</option>
                            <option>Cancelled</option>
                            <option>Finished</option>
                        </select>
                        <label class="focus-label">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <button type="submit" class="btn btn-success w-100"> Search </button>
                </div>
            </div>
        {!! Form::close() !!}
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table">
                    <thead>
                        <tr>
                            <th>Quiz Name</th>
                            <th>Expiry Date</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                   
                    <tbody id="tabledata">
                        @foreach($quiz as $quizs)
                        
                            
                            <td >{{$quizs->quizzes_name}}</td>
                       
                     
                            {{-- <td>Deadline:</td> --}}
                            <td>
                            
                                {{$quizs->exam_date}}
                            </td>
                     
                        
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-right" id="pagingdata" style="display: none;"></div>
        </div>
    </div>
   


@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/projects/projects.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection
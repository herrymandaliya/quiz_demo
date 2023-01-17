@extends('manage.layouts.admin')

@section('pagetitle', ' - Tasks')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Tasks</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tasks</li>
                </ul>
            </div>
            <div class="col-auto float-right ml-auto">
                <!-- <a href="{{ url_admin('tasks/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Project</a> -->
                <a href="javascript:void(0);" class="btn add-btn" data-toggle="modal" data-target="#add_project_modal">Add Project</a>
            </div>

        </div>
    </div>
    <?php /*
    <div class="filter-row">
        {!! Form::open(['url' => url_admin('tasks/load'), 'id' => 'searchform', 'class' => '']) !!}
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
                            <option value="0">In Discussion</option>
                            <option value="1">To Do</option>
                            <option value="2">In Progress</option>
                            <option value="3">QA</option>
                            <option value="4">Done</option>
                            <option value="5">Backlog</option>
                        </select>
                        <label class="focus-label">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <button type="submit" class="btn btn-success w-100"> Search </button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    */?>
    <div class="kanban-board card mb-0">
        <div class="card-body">
            <div class="kanban-cont">
                <div class="kanban-list kanban-info" id="project-discussion" data-status="0">
                    <div class="kanban-header">
                        <span class="status-title">In Discussion</span>
                    </div>
                    <div class="kanban-wrap">

                    </div>
                </div>
                <div class="kanban-list kanban-purple" id="project-todo" data-status="1">
                    <div class="kanban-header">
                        <span class="status-title">To Do</span>
                    </div>
                    <div class="kanban-wrap">

                    </div>
                </div>
                <div class="kanban-list kanban-warning" id="project-inprogress" data-status="2">
                    <div class="kanban-header">
                        <span class="status-title">In Progress</span>
                    </div>
                    <div class="kanban-wrap ks-empty"></div>
                </div>
                <div class="kanban-list kanban-primary" id="project-qa" data-status="3">
                    <div class="kanban-header">
                        <span class="status-title">QA</span>
                    </div>
                    <div class="kanban-wrap">

                    </div>
                </div>
                <div class="kanban-list kanban-success" id="project-done" data-status="4">
                    <div class="kanban-header">
                        <span class="status-title">Done</span>
                    </div>
                    <div class="kanban-wrap">
                    </div>
                </div>

                <div class="kanban-list kanban-danger" id="project-backlog" data-status="5">
                    <div class="kanban-header">
                        <span class="status-title">Backlog</span>
                    </div>
                    <div class="kanban-wrap">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="add_project_modal" class="modal custom-modal category-modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Project</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url' => url_admin('tasks/store'), 'id' => 'formproject', 'files' => true]) !!}
                    <nav class="d-none">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-category-tab" data-toggle="tab" href="#category-tab" role="tab" aria-controls="category-tab" aria-selected="true">Home</a>
                            <a class="nav-item nav-link" id="nav-project-tab" data-toggle="tab" href="#project-tab" role="tab" aria-controls="project-tab" aria-selected="false">Profile</a>
                            <a class="nav-item nav-link" id="nav-confirm-tab" data-toggle="tab" href="#confirm-tab" role="tab" aria-controls="confirm-tab" aria-selected="false">Contact</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="category-tab" role="tabpanel" aria-labelledby="nav-category-tab">

                            <div class="category-wrapper row form-group">
                                @if(!$categories->isEmpty())
                                @foreach($categories as $category)
                                <div class="col col-lg-4 col-md-4">
                                    <div class="category-box">
                                        <figure>
                                            <img src="{{$category->imagefilepath}}">
                                        </figure>
                                        <div class="category-name">{{$category->name}}</div>
                                        <input class="d-none" type="radio" name="category_id" value="{{$category->category_id}}">
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="project-tab" role="tabpanel" aria-labelledby="nav-project-tab">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="priority">Client <span class="text-danger">*</span></label>
                                    {!! Form::select('client_id', [null => 'Select client'] + $clients, null, ['class' => 'form-control select', 'id' => 'client_id'])!!}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                    {!! Form::text('start_date', null, ['class' => 'form-control datetimepicker2', 'id' => 'start_date']) !!}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="priority">Priority  <span class="text-danger">*</span></label>
                                    {!! Form::select('priority', [null => 'Select priority'] + config('constants.priority'), null, ['class' => 'form-control select', 'id' => 'priority'])!!}
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="manager_id">Project Manager  <span class="text-danger">*</span></label>
                                    {!! Form::select('manager_id', [null => 'Select priority'] + $projectmanagers, null, ['class' => 'form-control select', 'id' => 'manager_id'])!!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="confirm-tab" role="tabpanel" aria-labelledby="nav-confirm-tab">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    {!! Form::textarea('description', null, ['class' => 'form-control summernote', 'id' => 'description']) !!}
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="image">Upload Files</label>
                                    {!! Form::file('projectfile', ['id' => 'projectfile', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {!! Form::button('Back', ['id'=>'btnback', 'type' => 'button', 'class' => 'btn btn-secondary mt-3 d-none']) !!}
                        {!! Form::button('Submit', ['id'=>'btnsubmit', 'type' => 'button', 'class' => 'btn btn-primary mt-3']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/tasks/tasks.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

@extends('manage.layouts.admin')

@section('pagetitle', ' - Project')

@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Projects</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url_admin('projects') }}">Projects</a></li>
                <li class="breadcrumb-item active">{{ (empty($project)) ? 'Create' : 'Edit' }}</li>
            </ul>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">{{ (empty($project)) ? 'Please fill in the below fields to add a new user' : 'Please modify the details below' }}</h4>
    </div>
    <div class="card-body">
        {!! Form::model($project, ['url' => url_admin('projects/store'), 'id' => 'formproject', 'files' => true]) !!}
        {!! Form::hidden('project_id', null, ['id' => 'project_id']) !!}
        <div class="row">
            <div class="form-group col-md-6">
                <label for="title">Title <span class="text-danger">*</span></label>
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="priority">Client <span class="text-danger">*</span></label>
                {!! Form::select('client_id', [null => 'Select client'] + $clients, $project->client_id, ['class' => 'form-control select', 'id' => 'client_id'])!!}
            </div>
            <div class="form-group col-md-6">
                <label for="start_date">Start Date <span class="text-danger">*</span></label>
                {!! Form::text('start_date', null, ['class' => 'form-control datetimepicker2', 'id' => 'start_date']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="end_date">End Date <span class="text-danger">*</span></label>
                {!! Form::text('end_date', null, ['class' => 'form-control datetimepicker2', 'id' => 'end_date']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="priority">Priority  <span class="text-danger">*</span></label>
                {!! Form::select('priority', [null => 'Select priority'] + config('constants.priority'), $project->priority, ['class' => 'form-control select', 'id' => 'priority'])!!}
                
            </div>
            <div class="form-group col-md-6">
                <label for="manager_id">Project Manager  <span class="text-danger">*</span></label>
                {!! Form::select('manager_id', [null => 'Select priority'] + $projectmanagers, $project->manager_id, ['class' => 'form-control select', 'id' => 'manager_id'])!!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="priority">Team Members </label>
                <select class="form-control select" name="teammembers" id="teammembers">
                    <option value="">Select members</option>
                    @if(!$teammembers->isEmpty())
                        @foreach($teammembers as $key=>$teammember)
                            <option value="{{$teammember->user_id}}" data-image="{{$teammember->imagefilepath}}" data-name="{{$teammember->fullname}}" data-designation="{{$teammember->designationname}}">{{$teammember->fullname}} ({{$teammember->designationname}})</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group col-md-12 d-none" id="team-member-box">
                <div class="table-responsive">
                    <table class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th class="text-center width200">Chat Permission</th>
                                <th class="text-right width100">Action</th>
                            </tr>
                        </thead>
                        <tbody id="member-lists">
                            @if(!$addedteammembers->isEmpty())
                                @foreach($addedteammembers as $key=>$addedteammember)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="{{$addedteammember->member->fullname}}" src="{{$addedteammember->member->imagefilepath}}">
                                                </a>
                                                <a> {{$addedteammember->member->fullname}} <span>{{$addedteammember->member->designationname}}</span></a>
                                                <input type="hidden" name="teammemberid[]" value="{{$addedteammember->member->user_id}}">
                                            </h2>
                                        </td>
                                        <td class="text-center">
                                            <div class="chat-checkbox">
                                                <input type="checkbox" name="haspermission" {{($addedteammember->haschatpermission == 1)?'checked':''}}>
                                                <input type="hidden" name="chatpermission[]" value="{{$addedteammember->haschatpermission}}">
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <span class="position-relative">
                                                <span class="remove-member remove-icon">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="description">Description</label>
                {!! Form::textarea('description', null, ['class' => 'form-control summernote', 'id' => 'description']) !!}
            </div>

            <?php /*<div class="form-group col-md-6">
                <label for="image">Upload Files</label>
                {!! Form::file('files[]', ['id' => 'files', 'class' => 'form-control', 'multiple' => 'true']) !!}
            </div> */?>
        </div>


        <div class="text-right">
            <a class="btn btn-light mt-3" href="{{ url_admin('users') }}">Cancel</a>
            {!! Form::button('Submit', ['id'=>'btnsubmit', 'type' => 'submit', 'class' => 'btn btn-primary mt-3']) !!}
        </div>

    {!! Form::close() !!}
    </div>
</div>


@endsection


@section('page-scripts')
<script src="{{ asset_admin('js/projects/project.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

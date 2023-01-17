@extends('manage.layouts.admin')

@section('pagetitle', ' - Designation')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Designations</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url_admin('users') }}">Designations</a></li>
                    <li class="breadcrumb-item active">{{ (empty($designation->designation_id)) ? 'Create' : 'Edit' }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">{{ (empty($designation->designation_id)) ? 'Please fill in the below fields to add a new designations' : 'Please modify the details below' }}</h4>
        </div>
        <div class="card-body">
            {!! Form::model($designation, ['url' => url_admin('designations/store'), 'id' => 'formdesignation', 'files' => true]) !!}
            {!! Form::hidden('designation_id', null, ['id' => 'designation_id']) !!}
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Name<span class="text-danger">*</span></label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                </div>
                <div class="form-group col-md-6">
                    <label>Enabled</label>
                    <div class="onoffswitch statusswitch">
                        <input type="checkbox" value="1" name="status" class="onoffswitch-checkbox" id="switch_status" {{(!empty($designation) && $designation->status == 1)?'checked':'' }} {{(empty($designation->designation_id))?'checked':'' }}>
                        <label class="onoffswitch-label" for="switch_status">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a class="btn btn-light mt-3" href="{{ url_admin('designations') }}">Cancel</a>
                {!! Form::button('Submit', ['id'=>'btnsubmit', 'type' => 'submit', 'class' => 'btn btn-primary mt-3']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/designations/designation.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

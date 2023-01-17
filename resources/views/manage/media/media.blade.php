@extends('manage.layouts.admin')

@section('pagetitle', ' - Project')

@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Media</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Media</li>
            </ul>
        </div>
    </div>
</div>
<div class="filter-row">
    {!! Form::open(['url' => url_admin('users/load'), 'id' => 'searchform', 'class' => '']) !!}
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
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Priority</th>
                        <th>Media Count</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody id="tabledata"></tbody>
            </table>
        </div>
        <div class="text-right" id="pagingdata" style="display: none;"></div>
    </div>
</div>
@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/media/media.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

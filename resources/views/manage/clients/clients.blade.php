
@extends('manage.layouts.admin')

@section('pagetitle', ' - Clients')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Clients</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Clients</li>
                </ul>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="{{ url_admin('projects/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Project</a>
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
    <div class="row staff-grid-row">
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
           <div class="profile-widget">
              <div class="profile-img">
                 <a href="#" class="avatar"><img alt="" src="assets/img/profiles/avatar-19.jpg"></a>
              </div>
              <div class="dropdown profile-action">
                 <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                 </div>
              </div>
              <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-profile.html">Global Technologies</a></h4>
              <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-profile.html">Barry Cuda</a></h5>
              <div class="small text-muted">CEO</div>
              <a href="chat.html" class="btn btn-white btn-sm m-t-10">Message</a>
              <a href="#" class="btn btn-white btn-sm m-t-10">View Profile</a>
           </div>
        </div>

     </div>
@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/projects/projects.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

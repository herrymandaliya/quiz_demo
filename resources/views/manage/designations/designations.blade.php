@extends('manage.layouts.admin')

@section('pagetitle', ' - Designation')

@section('content')

    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
            <h3 class="page-title">Designations</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Designations</li>
            </ul>
            </div>
            <div class="col-auto float-end ms-auto">
            <a href="{{ url_admin('designations/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Create</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Enabled</th>
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
<script src="{{ asset_admin('js/designations/designations.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

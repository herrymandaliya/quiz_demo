@extends('manage.layouts.admin')

@section('pagetitle', ' - Media')

@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Media</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url_admin('projects') }}">Media</a></li>
                <li class="breadcrumb-item active">{{$project->title}}</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-9">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title m-b-20">Uploaded files</h5>
                <ul class="files-list">

                    @foreach($project->projectmedia as $projectmedia)
                    <li>
                        <div class="files-cont">
                            <div class="file-type">
                                <span class="files-icon"><a href="{{ url_admin('project-media/download/'.$projectmedia->projectmedia_id) }}" target="_blank"><i class="fa fa-download"></i></a></span>
                            </div>
                            <div class="files-info">
                                <span class="file-name text-ellipsis"><a href="#">{{$projectmedia->media_file}}</a></span>
                                <span class="file-author"><a href="#">{{$projectmedia->projectmessage->fromuser->fullname}}</a></span> <span class="file-date">{{$projectmedia->uploadtime}}</span>
                                <div class="file-size">Size: {{convertToReadableSize($projectmedia->media_size)}}</div>
                            </div>
                            <!-- <ul class="files-action">
                                <li class="dropdown dropdown-action">
                                    <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                    </div>
                                </li>
                            </ul> -->
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title m-b-15">Project details</h6>
                <table class="table table-striped table-border">
                    <tbody>

                        <tr>
                            <td>Created:</td>
                            <td class="text-right">{{$project->startdatestring}}</td>
                        </tr>
                        <tr>
                            <td>Deadline:</td>
                            <td class="text-right">{{$project->enddatestring}}</td>
                        </tr>
                        <tr>
                            <td>Priority:</td>
                            <td class="text-right">
                                {!! $project->prioritytext !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td class="text-right">{!! $project->statustext !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection


@section('page-scripts')
<script src="{{ asset_admin('js/projects/view.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

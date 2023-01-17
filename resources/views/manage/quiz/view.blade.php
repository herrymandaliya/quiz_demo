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

<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Quiz</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url_admin('projects') }}">Projects</a></li>
                <li class="breadcrumb-item active">{{$project->title}}</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-9">
        <div class="card">
            <div class="card-body">
                <div class="project-title">
                    <h5 class="card-title">{{$project->title}}</h5>
                </div>
                <div>
                    {!!$project->description!!}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title m-b-20">Uploaded files</h5>
                <ul class="files-list">
                    <li>
                        <div class="files-cont">
                            <div class="file-type">
                                <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                            </div>
                            <div class="files-info">
                                <span class="file-name text-ellipsis"><a href="#">AHA Selfcare Mobile Application Test-Cases.xls</a></span>
                                <span class="file-author"><a href="#">John Doe</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                <div class="file-size">Size: 14.8Mb</div>
                            </div>
                            <ul class="files-action">
                                <li class="dropdown dropdown-action">
                                    <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="files-cont">
                            <div class="file-type">
                                <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                            </div>
                            <div class="files-info">
                                <span class="file-name text-ellipsis"><a href="#">AHA Selfcare Mobile Application Test-Cases.xls</a></span>
                                <span class="file-author"><a href="#">Richard Miles</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                <div class="file-size">Size: 14.8Mb</div>
                            </div>
                            <ul class="files-action">
                                <li class="dropdown dropdown-action">
                                    <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card project-chat-card">
            <div class="card-body">
                <h5 class="card-title m-b-20">Discussion</h5>
                <div class="chat-contents">
                    <div class="chat-content-wrap">
                        <div class="chat-wrap-inner">
                            <div class="chat-box">
                                <div class="chats" id='loadmessages'>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-footer">
                    {!! Form::model(null,['url' => url_admin('projects/sendmessage'), 'id' => 'formprojectmessage']) !!}
                    <div class="message-bar">
                        <div class="message-inner">

                            <label class="link attach-icon cursor-pointer cursor-pointer" >
                                <input type="file" class="d-none" name="messageFiles[]" id="messageFiles" multiple />
                                <img src="{{asset_admin('img/attachment.png')}}" alt="">
                            </label>
                            <div class="message-area">
                                {!! Form::hidden('project_id', $project->project_id, ['id' => 'project_id']) !!}
                                <div class="input-group form-group m-0">
                                    {!! Form::text('message', null, ['class'=>'form-control', 'placeholder'=>'Type Message', 'id'=>'message']) !!}
                                    <span class="input-group-append">
                                    <button class="btn btn-custom send-msg-btn" type="button"><i class="fa fa-send"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
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
        <div class="card project-user">
            <div class="card-body">
                <h6 class="card-title m-b-20">Assigned Leader</h6>
                <ul class="list-box">
                    <li>
                        <a href="#">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar"><img alt="{{$project->projectmanager->fullname}}" src="{{$project->projectmanager->imagefilepath}}"></span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">{{$project->projectmanager->fullname}}</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">{{$project->projectmanager->designationname}}</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card project-user">
            <div class="card-body">
                <h6 class="card-title m-b-20">
                    Assigned users
                </h6>
                @if(!$project->projectmembers->isEmpty())
                <ul class="list-box">
                    @foreach($project->projectmembers as $projectmember)
                    <li>
                        <a href="profile.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar"><img alt="{{$projectmember->member->fullname}}" src="{{$projectmember->member->imagefilepath}}"></span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">{{$projectmember->member->fullname}}</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">{{$projectmember->member->designationname}}</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection


@section('page-scripts')
<script src="{{ asset_admin('js/projects/view.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

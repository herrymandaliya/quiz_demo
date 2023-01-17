@if(!$projects->isEmpty())
    @foreach($projects as $key=>$value)


        


        <div class="card panel project-card" data-project_id="{{$value->project_id}}">
            <div class="kanban-box">
                <div class="task-board-header">
                    <span class="status-title"><a href="#">{{$value->title}}</a></span>
                    <div class="dropdown kanban-task-action">
                        <a href="" data-toggle="dropdown">
                        <i class="fa fa-angle-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url_admin('tasks/view/'.$value->project_id) }}"><i class="fa fa-eye m-r-5"></i> View</a>
                            <a class="dropdown-item" href="{{ url_admin('tasks/edit/'.$value->project_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteEntity({{ $value->project_id }});"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <div class="task-board-body">
                    <div class="kanban-footer">
                        <div class="task-info-cont">
                            <span class="task-date"><i class="fa fa-clock-o"></i> {{$value->startdatestring}}</span>
                            {!!$value->prioritytext!!}
                        </div>
                        <?php /*
                        <div class="project-members m-b-15">
                            <div>Project Leader :</div>
                            <ul class="team-members">
                                <li>
                                    <a href="javascript:void(0)" data-toggle="tooltip"  title="{{$value->projectmanager->fullname}}"><img src="{{$value->projectmanager->imagefilepath}}" alt="{{$value->projectmanager->fullname}}"></a>
                                </li>
                            </ul>
                        </div>
                        @if(!$value->projectmembers->isEmpty())
                        <div class="project-members m-b-15">
                            <div>Team :</div>
                            <ul class="team-members">
                                @foreach($value->projectmembers as $projectmembers)
                                    <li>
                                        <a href="javascript:void(0)" data-toggle="tooltip"  title="{{$projectmembers->member->fullname}}"><img src="{{$projectmembers->member->imagefilepath}}" alt="{{$projectmembers->member->fullname}}"></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        */ ?>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


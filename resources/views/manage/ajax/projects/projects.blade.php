@if(!$projects->isEmpty())
    @foreach($projects as $key=>$value)


        <tr>
            <td>
                {{$value->title}}
            </td>
            <td>
                <h2 class="table-avatar">
                    <span class="avatar"><img src="{{$value->projectmanager->imagefilepath}}" alt="{{$value->projectmanager->fullname}}"></span>
                    <h5 class="d-inline-block">{{$value->projectmanager->fullname}}</h5>
                </h2>
            </td>
            <td>
                <ul class="team-members text-nowrap">
                    @foreach($value->projectmembers as $projectmembers)
                        <li>
                            <a href="javascript:void(0)" data-toggle="tooltip"  title="{{$projectmembers->member->fullname}}"><img alt="{{$projectmembers->member->fullname}}" src="{{$projectmembers->member->imagefilepath}}"></a>
                        </li>
                    @endforeach
                </ul>
            </td>
            <td>{{$value->startdatestring}} </td>
            <td>{!!$value->prioritytext!!} </td>
            <td>{!!$value->statustext!!} </td>
            <td class="text-right">
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ url_admin('projects/view/'.$value->project_id) }}"><i class="fa fa-eye m-r-5"></i> View</a>
                        <a class="dropdown-item" href="{{ url_admin('projects/edit/'.$value->project_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteEntity({{ $value->project_id }});"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" class="text-center">
            <h4 class="m-0">No projects found!</h4>
        </td>
    </tr>
@endif
<tr id="ajaxpagingdata">
    <td>
        {!! $projects->render() !!}
    </td>
</tr>

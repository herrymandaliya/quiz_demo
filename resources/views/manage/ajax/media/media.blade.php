@if(!$projects->isEmpty())
    @foreach($projects as $key=>$value)

        <tr>
            <td>
                {{$value->title}}
            </td>

            <td>{!!$value->prioritytext!!} </td>
            <td>{{count($value->projectmedia)}}</td>
            <td>{!!$value->statustext!!} </td>
            <td class="text-right">
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ url_admin('project-media/view/'.$value->project_id) }}"><i class="fa fa-eye m-r-5"></i> View</a>
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

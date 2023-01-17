@if(!$designation->isEmpty())
    @foreach($designation as $key=>$value)
        <tr >
            <th scope="row">{{ ( ($designation->currentPage() - 1 ) * $designation->perPage() ) + $key + 1 }}</th>
            <td>
                {{$value->name}}
            </td>
            <td>
                {!!$value->statustext!!}
            </td>
            <td class="text-right">
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ url_admin('designation/edit/'.$value->designation_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteEntity({{ $value->designation_id }});"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5" class="text-center">
            <h4 class="m-0">No Designation found!</h4>
        </td>
    </tr>
@endif
<tr id="ajaxpagingdata">
    <td>
        {!! $designation->render() !!}
    </td>
</tr>

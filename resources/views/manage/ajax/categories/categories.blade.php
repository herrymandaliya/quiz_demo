@if(!$categories->isEmpty())
    @foreach($categories as $key=>$value)
        <tr >
            <th scope="row">{{ ( ($categories->currentPage() - 1 ) * $categories->perPage() ) + $key + 1 }}</th>
            <td>
                <h2 class="table-avatar">
                    <span class="avatar bg-transparent"><img src="{{$value->imagefilepath}}" alt=""></span>
                    <a>{{$value->name}}</a>
                </h2>
            </td>
            <td>
                {!!$value->statustext!!}
            </td>
            <td class="text-right">
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ url_admin('categories/edit/'.$value->category_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteEntity({{ $value->category_id }});"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5" class="text-center">
            <h4 class="m-0">No categories found!</h4>
        </td>
    </tr>
@endif
<tr id="ajaxpagingdata">
    <td>
        {!! $categories->render() !!}
    </td>
</tr>

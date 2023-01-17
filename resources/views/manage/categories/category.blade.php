@extends('manage.layouts.admin')

@section('pagetitle', ' - Categories')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Categories</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url_admin('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url_admin('users') }}">Categories</a></li>
                    <li class="breadcrumb-item active">{{ (empty($category->category_id)) ? 'Create' : 'Edit' }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">{{ (empty($category->category_id)) ? 'Please fill in the below fields to add a new categories' : 'Please modify the details below' }}</h4>
        </div>
        <div class="card-body">
            {!! Form::model($category, ['url' => url_admin('categories/store'), 'id' => 'formcategory', 'files' => true]) !!}
            {!! Form::hidden('category_id', null, ['id' => 'category_id']) !!}
            <input name="deleteimage" id="deleteimage" type="hidden" value="0" class="form-control" />
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Name<span class="text-danger">*</span></label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                </div>
                <div class="form-group col-md-6">
                    <label for="image">Image</label>
                    <div>
                        <h2 class="form-control-avatar">
                            <div class="avatar">
                                <img src="{{ $category->imagefilepath }}" alt="Category image">
                                @if($category->hasimage)
                                    <span class="la la-close remove-img" title="Remove" onclick="removeCategoryPic();"></span>
                                @endif
                            </div>
                            {!! Form::file('imagefile', ['id' => 'imagefile', 'class' => 'form-control']) !!}
                        </h2>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Enabled</label>
                    <div class="onoffswitch statusswitch">
                        <input type="checkbox" value="1" name="status" class="onoffswitch-checkbox" id="switch_status" {{(!empty($category) && $category->status == 1)?'checked':'' }} {{(empty($category->category_id))?'checked':'' }}>
                        <label class="onoffswitch-label" for="switch_status">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a class="btn btn-light mt-3" href="{{ url_admin('categories') }}">Cancel</a>
                {!! Form::button('Submit', ['id'=>'btnsubmit', 'type' => 'submit', 'class' => 'btn btn-primary mt-3']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('page-scripts')
<script src="{{ asset_admin('js/categories/category.js?cache=1.0.'.getCacheCounter()) }}"></script>
@endsection

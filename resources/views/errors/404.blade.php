@extends('manage.layouts.admin')

@section('content')
<section class="content-header">
	<h1>404 Error Page</h1>
	<ol class="breadcrumb">
        <li><a href="{{ url('/manage') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">404 error</li>
    </ol>
</section>
<section class="content">
	<div class="error-page">
		<h2 class="headline text-yellow m0"> 404</h2>
		<div class="error-content pt5">
			<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
			<p>
				We could not find the page you were looking for.
				Meanwhile, you may return to <a href="{{ url('/manage/dashboard') }}">dashboard</a>.
			</p>
		</div>
	</div>
</section>
@endsection
@extends('front.layouts.front')

@section('pagetitle', ' - ' . $pagetitle)
@section('page-css')

@endsection

@section('content')

	<main class="main">
		<nav aria-label="breadcrumb" class="breadcrumb-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page">{{ $pagetitle }}</li>
				</ol>
			</div><!-- End .container -->
		</nav>


		<div class="container">
			<div class="page-not-found-block">
				<div class="error-icon"><i class="fa fa-exclamation-triangle"></i></div>
				<h4>{{ $pagetitle }}</h4>
				@if($statuscode == 404)
				<h5>
					{{ getTranslation('We could not find the page you were looking for. Meanwhile, you may return to') }}
					<a href="{{ url('/') }}" class=""> {{ getTranslation('home page.') }} </a>
				</h5>
				@endif
			</div>
		</div><!-- End .container -->

		<div class="mb-6"></div><!-- margin -->
	</main><!-- End .main -->
@endsection

@section('page-scripts')
@endsection
<!DOCTYPE html>
<html lang="en">
<head>

	@include('front.layouts.head')

	@yield('page-css')

</head>
<body>
	<div class="page-wrapper">
		

		@yield('content')

		
	</div><!-- End .page-wrapper -->

	@include('front.layouts.foot')

	@yield('page-scripts')

</body>
</html>
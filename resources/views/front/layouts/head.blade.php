<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="base-url" content="{{ url('/') }}" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>@yield('pagetitle')</title>

<meta name="keywords" content="" />
<meta name="title" content="">
<meta name="description" content="">
<meta name="author" content="SW-THEMES">

<!-- Favicon -->
<link rel="shortcut icon" href="" />


<!-- Plugins CSS File -->
<link rel="stylesheet" href="{{ asset_front('/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('/front-common/css/PNotify.css') }}">
<link rel="stylesheet" href="{{ asset('/front-common/css/common.css') }}">
<link rel="stylesheet" href="{{ asset('/front/css/multi-form.css') }}">

<!-- Main CSS File -->
<link rel="stylesheet" href="{{ asset_front('/css/style.css') }}">
<link rel="stylesheet" href="{{ asset_front('/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset_front('/css/style_1.css') }}">

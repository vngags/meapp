<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('site_title') - CocCoc.me</title>

	<!-- Styles -->
	<link href="{{ mix('css/app.css') }}" rel="stylesheet"> @yield('style')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('plugins/swal/sweetalert2.css') }}"> @stack('style')
</head>

<body class="@yield('body_class') preload">
	<div id="app">
		@if(Auth::check())
		<init></init>
		<listen :id="{{ Auth::user()->id }}"></listen>
		@endif @include('layouts.blocks._navbar')
		<div>
			@yield('content')
		</div>
		<div style="padding-bottom:100px"></div>
	</div>
	@include('layouts.blocks._footer')

	<!-- Scripts -->
	<script src="{{ mix('js/app.js') }}"></script>
	<script src="{{ mix('js/frontend.js') }}"></script>

	@stack('script')
	<!-- stack use push -->
	@include('layouts.blocks._modal')
	<script>
		
	</script>
</body>

</html>
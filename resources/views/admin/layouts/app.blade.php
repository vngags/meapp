<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('site_title')</title>

	<!-- Styles -->
	<link href="{{ mix('css/app.css') }}" rel="stylesheet"> @yield('style')
</head>

<body class="@yield('body_class')">
	<div id="app">
		@include('layouts.blocks._navbar')
		<div style="margin-top:80px">
			@yield('content')
		</div>
	</div>


	<!-- Scripts -->
	<script src="{{ mix('js/app.js') }}"></script>
	<script src="{{ mix('js/frontend.js') }}"></script>
	@yield('script') @include('layouts.blocks._login_modal')
</body>

</html>
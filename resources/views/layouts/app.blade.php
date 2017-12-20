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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/swal/sweetalert2.css') }}">
</head>

<body class="@yield('body_class')">
	<div id="app">
        @if(Auth::check())
            <init></init>   
        @endif
		@include('layouts.blocks._navbar') @yield('content')        
	</div>


	<!-- Scripts -->
	<script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/frontend.js') }}"></script>
	@yield('script')
    @include('layouts.blocks._login_modal')
    <script>
        $(document).ready(() => {
            var formLogin = $('#modal-login');
            formLogin.submit((e) => {
                e.preventDefault();
                var formData = formLogin.serialize();
                $.ajax({
                    url: "{{route('login')}}",
                    type: 'POST',
                    data: formData,
                    success: (data) => {
                        if(data.user) {
                            window.location.href=data.intended
                        }
                    },
                    error: (err) => {
                        console.log(err)
                    }
                });
            });
        });
    </script>
</body>

</html>
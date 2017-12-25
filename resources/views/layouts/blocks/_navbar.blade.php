<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">

			<!-- Collapsed Hamburger -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<!-- Branding Image -->
			<a class="navbar-brand" href="{{ url('/') }}">
				<img src="{{ asset('images/svg/bird.svg') }}" class="_ibi"> {{ config('app.name', 'Laravel') }}
			</a>
		</div>

		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			<!-- Left Side Of Navbar -->
			<ul class="nav navbar-nav">
				@if(Auth::check())
				<li>
					<a href="{{ route('product.index', ['user_slug' => Auth::user()->slug]) }}">Products</a>
				</li>
				@endif
			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="nav navbar-nav navbar-right">
				<!-- Authentication Links -->
				@guest
				<li>
					<a href="{{ route('login') }}">Login</a>
				</li>
				<li>
					<a href="{{ route('register') }}">Register</a>
				</li>
				@else
				<li>
					<unread-notification></unread-notification>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
						<div class="img-circle border-outline _ib outline-circle">
							<img src="{{ Auth::user()->avatar }}" width="24" class="img-circle">
						</div>
						{{ Auth::user()->name }}
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu">
						@role('Admin')
						<li>
							<a href="{{ route('admin.dashbroad') }}">
								<i class="fa fa-cog"></i> Admin</a>
						</li>
						@endrole
						<li>
							<a href="{{ route('profile.index', ['slug' => Auth::user()->slug]) }}">
								<i class="fa fa-user"></i> Profile</a>
						</li>
						<li>
							<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out"></i> Logout
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
				@endguest
			</ul>
		</div>
	</div>
</nav>
<nav class="navbar navbar-default navbar-static">
	<div class="navbar-top" style="background:#000;">
		<div class="container">
			<div class="topbar-banner" style="padding: 10px 10px 0">
				<img src="{{ asset('images/topbanner.jpg') }}" alt="">
			</div>
			<div class="navbar-menu">
				<ul class="list-inline">
					@if(Auth::check())
					<li class="active">
						<a href="{{ route('product.index', ['user_slug' => Auth::user()->slug]) }}">Sản phẩm</a>
					</li>
					@endif
					<li>
						<a href="">Địa điểm</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="navbar-bottom">
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
					<img src="{{ asset('images/svg/bird.svg') }}" class="_ibi"> CocCoc
				</a>
			</div>

			<div class="collapse navbar-collapse" id="app-navbar-collapse">
				<!-- Left Side Of Navbar -->
				<ul class="nav navbar-nav">
					<div class="search-bar">

						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Địa điểm
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li>
									<a href="#">Tìm sản phẩm</a>
								</li>
								<li>
									<a href="#">Tìm thành viên</a>
								</li>
								<li>
									<a href="#">Tìm thương hiệu</a>
								</li>
							</ul>
						</div>

						<div class="dropdown" id="search-type" style="margin-left:5px">
							<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								<span class="btn-label">
									@if(app('request')->input('type') && app('request')->input('type') == 'product') Sản phẩm @elseif(app('request')->input('type')
									&& app('request')->input('type') == 'member') Thành viên @elseif(app('request')->input('type') && app('request')->input('type')
									== 'brand') Thương hiệu @else Sản phẩm @endif
								</span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li>
									<a id="type-product" href="javascript:void(0)">Tìm sản phẩm</a>
								</li>
								<li>
									<a id="type-member" href="javascript:void(0)">Tìm thành viên</a>
								</li>
								<li>
									<a id="type-brand" href="javascript:void(0)">Tìm thương hiệu</a>
								</li>
							</ul>
						</div>
						<form action="{{ route('search.get') }}" method="GET">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm, thành viên,..." name="q" id="q" autocomplete="off"> @if(app('request')->input('type') && app('request')->input('type') == 'product')
								<input type="hidden" name="type" id="hidden-product-type" value="product"> @elseif(app('request')->input('type') && app('request')->input('type') == 'member')
								<input type="hidden" name="type" id="hidden-product-type" value="member"> @elseif(app('request')->input('type') && app('request')->input('type') == 'brand')
								<input type="hidden" name="type" id="hidden-product-type" value="brand"> @else
								<input type="hidden" name="type" id="hidden-product-type" value="product"> @endif

								<div class="input-group-btn">
									<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
										<i class="fa fa-sliders"></i> Bộ lọc</button>
									<button type="submit" class="btn btn-default">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</div>
						</form>
					</div>

				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					<!-- Authentication Links -->
					@guest
					<li>
						<a href="{{ route('login') }}">
							<i class="fa fa-sign-in"></i> Đăng nhập</a>
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
	</div>
</nav>
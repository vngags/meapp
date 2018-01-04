@extends('layouts.app') 
@section('site_title', 'Trang chủ')
@section('content')
<div class="container">
	<div class="row">

        <div class="col-md-4">
            <img src="http://placehold.it/195x600" alt="">
        </div>

		<div class="col-md-20">
			<div class="panel panel-default">
				<div id="heading-position" class="panel-heading clearfix">
					Product List @can('create', App\Product::class)
					<span class="pull-right">
						<a href="{{ route('product.create', ['user_slug' => Auth::user()->slug]) }}" class="btn btn-sm btn-primary">Tạo mới</a>
					</span>
					@endcan
				</div>

				{{--  Fixed topbar  
				<div class="heading-fixed">
					<div class="container">
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-20">
								<div class="panel panel-default">
									<div class="panel-heading clearfix">
										Product List @can('create', App\Product::class)
										<span class="pull-right">
											<a href="{{ route('product.create', ['user_slug' => Auth::user()->slug]) }}" class="btn btn-sm btn-primary">Tạo mới</a>
										</span>
										@endcan
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>				
				  Fixed topbar  --}}

				<div class="panel-body row" style="padding: 15px 0;">
					@if(app('request')->input('page'))
						<index :page="{{ app('request')->input('page') }}"></index>
					@else
						<index></index>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
<style>
.heading-fixed {
	position: fixed;
	top: 48px;
	transition: all .3s;
	z-index: 888;
	height: 36px;
	-webkit-transform: translate(0,-100%) translateZ(0);
	-khtml-transform: translate(0,-100%) translateZ(0);
	transform: translate(0,-147px) translateZ(0);
	width: 100%;
	left: 0;
}	
.heading-fixed .panel-heading {
	height: 36px;
	line-height: 36px;
	padding: 0 15px;
	border-radius: 0;
}
.is_active.heading-fixed {
	-webkit-transform: translate(0,0) translateZ(0);
    -khtml-transform: translate(0,0) translateZ(0);
    transform: translate(0,0) translateZ(0);
}

</style>
@endsection
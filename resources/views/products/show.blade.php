@extends('layouts.app') @section('site_title', $product->title) @section('content')
<div class="container" style="padding-bottom:100px">
	<div class="row">
		<div class="col-md-17">
			<div class="white-bg">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						Product Detail @can('update', $product)
						<span class="pull-right" style="margin-left:10px">
							<a href="{{ route('product.edit', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}" class="btn btn-sm btn-primary">Chỉnh sửa</a>
						</span>
						@endcan @can('delete', $product)
						<span class="pull-right">
							<a class="btn btn-sm btn-danger" href="{{ route('product.destroy', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}"
							 onclick="event.preventDefault();
                                                                 document.getElementById('delete-form').submit();">
								Xóa
							</a>

							<form id="delete-form" action="{{ route('product.destroy', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}"
							 method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</span>
						@endcan
					</div>

					<div class="panel-body">
						<h1>{{ $product->title }}</h1>
						<small>
							<a href="{{ route('profile.index', ['slug' => $product->user->slug]) }}">{{ $product->user->name }}</a>
						</small>
						<div class="form-group">
							<p>
								{{ $product->body }}
							</p>
							{{-- Price --}}
							<div class="product-price">
								@if($product->new_price || $product->price) @if($product->new_price && $product->price)
								<div class="new_price">
									<span class="currency">đ</span>{{ number_format($product->new_price, 0, ',', '.') }}.000
								</div>
								<div class="old_price">
									<span class="currency">đ</span>{{ number_format($product->price, 0, ',', '.') }}.000 -{{ round(($product->price - $product->new_price)
									/ $product->price * 100) }}%
								</div>
								@elseif($product->new_price)
								<div class="new_price">
									<span class="currency">đ</span>{{ number_format($product->new_price, 0, ',', '.') }}.000
								</div>
								@else
								<div class="new_price">
									<span class="currency">đ</span>{{ number_format($product->price, 0, ',', '.') }}.000
								</div>
								@endif @elseif($product->price_start || $product->price_end) @if($product->price_start && $product->price_end)
								<div class="start_price">
									<span class="currency">đ</span>{{ number_format($product->price_start, 0, ',', '.') }}.000
								</div> -
								<div class="end_price">
									<span class="currency">đ</span>{{ number_format($product->price_end, 0, ',', '.') }}.000
								</div>
								@elseif($product->price_start) Giá chỉ từ:
								<div class="start_price">
									<span class="currency">đ</span>{{ number_format($product->price_start, 0, ',', '.') }}.000
								</div>
								@else Giá dưới:
								<div class="end_price">
									<span class="currency">đ</span>{{ number_format($product->price_end, 0, ',', '.') }}.000
								</div>
								@endif @elseif($product->price)
								<div class="price">
									<span class="currency">đ</span>{{ number_format($product->price, 0, ',', '.') }}.000</div>
								@else
								<div class="price">Liên hệ</div>
								@endif
							</div>
							{{-- Price --}}
						</div>
						<h4>Hình ảnh sản phẩm
							<small class="badge">{{ count($product->attachments) }}</small>
						</h4>
						<ul class="scroller product-images list-inline">
							@foreach($product->attachments as $attachment)
							<li class="col-md-6">
								<a href="" class="border-outline _ibi">
									<img src="{{ url('/images/' . $product->user->uid . '/' . FunctionHelper::getImageVersion($attachment->original_url, 'large')) }}"> @if($attachment->image_detail)
									<div class="image-price">
										<span>{{ $attachment->image_detail->media_price }}.000 đ</span>
									</div>
									@endif
								</a>
							</li>
							@endforeach
						</ul>
					</div>
					<div class="panel-footer">
						@if(Auth::check())
						<a href="{{ route('product.index', ['user_slug' => Auth::user()->slug]) }}" class="text-center btn btn-sm btn-default">Back to list</a>
						@else
						<a href="{{ route('home') }}" class="btn btn-sm btn-default">Back to home</a>
						@endif
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection @section('style')
<style>
	.product-price div {
		font-family: Arial;
		position: relative;
	}

	.old_price {
		text-decoration: line-through;
		font-weight: bold;
		color: #999;
	}

	.new_price,
	.price,
	.start_price,
	.end_price {
		font-size: 24px;
		font-weight: bold;
		color: #ff9b46;
		margin-right: 10px;
	}

	.currency {
		top: 5px !important;
		left: -2px !important;
		font-size: 14px !important;
	}

	.product-images {
		max-height: 545px;
	}

	.product-images li {
		margin-bottom: 5px;
	}

	.product-images li a {
		position: relative;
		width: 100%;
		height: 100%;
		overflow: hidden;
	}

	.product-images li a::after {
		padding-bottom: 100%;
		content: "";
		display: block;
	}

	.product-images li a img {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}

	.image-price {
		width: 100%;
		height: 36px;
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		background: #000;
		background: -moz-linear-gradient(rgba(0, 0, 0, 0), #000);
		background: linear-gradient(rgba(0, 0, 0, 0), #000);
	}

	.image-price span {
		text-align: center;
		display: block;
		line-height: 40px;
		font-size: 13px;
		font-weight: 600;
		color: #fff;
	}
</style>
@endsection
@foreach($products as $product)
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-sx-24 product-item">
	<div class="white-bg">
		@if(count($product->attachments) > 0) @include('layouts.blocks._product_images') @else
		<ul class="list-inline attachments clearfix">
			<li class="full-image">
				<a class="border-outline" href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}" title="{{ $product->title }}">
					<img src="{{ asset('images/no-image.png') }}" title="{{ $product->title }}" alt="{{ $product->title }}">
				</a>
			</li>
		</ul>
		@endif
		<div class="product-item-body">
			<h3>
				<a href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}" title="{{ $product->title }}">
					{{ $product->title }}
				</a>
			</h3>
			<span class="product-body">{{ FunctionHelper::truncate($product->body) }}</span>
			<div>
				{{--  Price  --}}
				<div class="product-price">
					@if($product->new_price || $product->price)		
						@if($product->new_price && $product->price)
							<div class="new_price">
								<span class="currency">đ</span>{{ number_format($product->new_price, 0, ',', '.') }}.000
							</div>
							<div class="old_price">
								<span class="currency">đ</span>{{ number_format($product->price, 0, ',', '.') }}.000 -{{ round(($product->price - $product->new_price) / $product->price * 100) }}%
							</div>
						@elseif($product->new_price)
							<div class="new_price">
								<span class="currency">đ</span>{{ number_format($product->new_price, 0, ',', '.') }}.000
							</div>
						@else
							<div class="new_price">
								<span class="currency">đ</span>{{ number_format($product->price, 0, ',', '.') }}.000
							</div>
						@endif					
					@elseif($product->price_start || $product->price_end)
						@if($product->price_start && $product->price_end)
						<div class="start_price">
							<span class="currency">đ</span>{{ number_format($product->price_start, 0, ',', '.') }}.000
						</div> -
						<div class="end_price">
							<span class="currency">đ</span>{{ number_format($product->price_end, 0, ',', '.') }}.000
						</div>
						@elseif($product->price_start)
							Giá chỉ từ:
							<div class="start_price">
								<span class="currency">đ</span>{{ number_format($product->price_start, 0, ',', '.') }}.000
							</div>
						@else
							Giá dưới: 
							<div class="end_price">
								<span class="currency">đ</span>{{ number_format($product->price_end, 0, ',', '.') }}.000
							</div>
						@endif					
					@elseif($product->price)
					<div class="price">
						<span class="currency">đ</span>{{ number_format($product->price, 0, ',', '.') }}.000</div>
					@else
					<div class="price">Liên hệ</div>
					@endif
				</div>
				{{--  Price  --}}
				{{--  Shiping Icon  --}}
				<div class="ship-icon">
					<i class="fa fa-truck fa-flip-horizontal btn btn-sm btn-default"><span class="fa fa-flip-horizontal">FREE</span></i>
				</div>
				{{--  ship-icon  --}}
			</div>			
		</div>
		<div class="product-item-footer">
			<div class="author">
				<a href="{{ route('profile.index', ['slug' => $product->user->slug]) }}">
					<div class="img-circle border-outline _ib outline-circle">
						<img src="{{ $product->user->avatar }}" width="24" class="img-circle">
					</div>
				</a>
				<a href="{{ route('profile.index', ['slug' => $product->user->slug]) }}">{{ $product->user->name }}</a>
			</div>
		</div>
	</div>
</div>
@endforeach

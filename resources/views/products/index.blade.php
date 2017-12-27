@extends('layouts.app') @section('content')
<div class="container">
	<div class="row">

        <div class="col-md-4">
            <img src="http://placehold.it/195x600" alt="">
        </div>

		<div class="col-md-20">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					Product List @can('create', App\Product::class)
					<span class="pull-right">
						<a href="{{ route('product.create', ['user_slug' => Auth::user()->slug]) }}" class="btn btn-sm btn-primary">Tạo mới</a>
					</span>
					@endcan
				</div>

				<div class="panel-body row" style="padding: 15px 0;">

					@foreach($products as $product)
                        <div class="col-md-8 col-sm-12 col-xs-12 col-sx-24 product-item">
                            <div class="white-bg">
                                @if($product->attachments)
                                    @include('layouts.blocks._product_images')
                                @endif
                                <div class="product-item-body">
                                    <h3>
                                        <a href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}">
                                            {{ $product->title }}
                                           
                                        </a>
                                    </h3>                        
                                    <span class="product-body">{{ FunctionHelper::truncate($product->body) }}</span>
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

				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
    <style>
        .product-item {
            height: 410px;
        }
        .product-item-body {
            padding: 10px;
        }
        .product-item-body h3 {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
            font-size: 1.3em;
            margin: 0;
            line-height: 1.3em;
            text-overflow: ellipsis;
            height: 2.6em;
        }
        .product-body {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
        }
        .product-item-footer {
            padding: 10px;
            border-top: 1px solid #eee;
        }
    </style>
@endsection
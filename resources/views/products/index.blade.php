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
                        <div class="col-md-8">
                            <div class="white-bg">
                                @if($product->attachments)
                                    @include('layouts.blocks._product_images')
                                @endif
                                <div class="product-item-body">
                                    <h3>
                                        <a href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}">
                                            {{ $product->title }}
                                            <small class="pull-right">
                                                <a href="{{ route('profile.index', ['slug' => $product->user->slug]) }}">{{ $product->user->name }}</a>
                                            </small>
                                        </a>
                                    </h3>                        
                                    {{ FunctionHelper::truncate($product->body) }}
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
        .product-item-body {
            padding: 10px;
        }
    </style>
@endsection
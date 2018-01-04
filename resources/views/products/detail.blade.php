@extends('layouts.app') @section('site_title', $product->title) @section('content')
<div class="container" style="padding-bottom:100px">
	<div class="row">
        <div class="col-md-17">
            <product-show :slug=`{{ $product->user->slug . '/post/' . $product->slug }}`></product-show>
        </div>
    </div>
</div>
@endsection

@section('style')
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
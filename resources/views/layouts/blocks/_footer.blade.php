<div class="cc-back-top">
	<ul>
		@if(Auth::check()) @can('create', App\Product::class)
		<li class="product-create">
			<a href="{{ route('product.create', ['user_slug' => Auth::user()->slug]) }}">
				<span class="glyphicon glyphicon-pencil"></span>
				<label>Đăng bán</label>
			</a>
		</li>
		@endcan @endif
		<li class="back-to-top">
			<a href="javascript:void(0)">
				<i class="fa fa-angle-up"></i>
				<label>Lên đầu trang</label>
			</a>
		</li>
	</ul>
</div>
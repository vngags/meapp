@extends('layouts.app')
@section('site_title', 'Tìm kiếm: ' . $query)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img src="http://placehold.it/195x600" alt="">
        </div>
        <div class="col-md-20">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Tìm kiếm: {{ $query }}
                    <small class="pull-right">
                        @if(count($products) > 0)
                        Tìm thấy {{ $products->total() }} kết quả
                        @else
                        Không tìm thấy sản phẩm phù hợp
                        @endif
                    </small>
                </div>

                <div class="panel-body row" style="padding: 15px 0;">
                    @include('layouts.blocks._loop_product')
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{--  <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Product Detail</div>

                <div class="panel-body">
                    <div class="panel-body">
                        <form action="{{ route('product.update', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" value="{{ $product->title }}" name="title">
                            </div>

                            <div class="form-group">
                                <label>Body</label>
                                <textarea name="body" class="form-control" cols="30" rows="10">{{ $product->body }}</textarea>
                            </div>
                            
                            <div class="form-group clearfix">
                                <a class="btn btn-default" href="{{ route('product.show', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}">Back</a>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>  --}}
        <product-form :product_id="{{ $product->id }}"></product-form>
    </div>
</div>
@endsection

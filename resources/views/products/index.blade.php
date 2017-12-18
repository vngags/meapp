@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Product List
                    @can('create-post')
                        <span class="pull-right">
                            <a href="{{ route('product.create', ['user_slug' => Auth::user()->slug]) }}" class="btn btn-sm btn-primary">Create</a>
                        </span>
                    @endcan
                </div>

                <div class="panel-body">
                    
                    @foreach($products as $product)
                        <div>
                            <h3><a href="{{ route('product.show', ['user_slug' => $product->user->slug, 'slug' => $product->slug]) }}">{{ $product->title }}</a></h3>
                            {{ $product->body }}
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

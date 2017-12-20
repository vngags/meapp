@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Product Detail
                    @can('update', $product)
                        <span class="pull-right">
                            <a href="{{ route('product.edit', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}" class="btn btn-sm btn-primary">Edit</a>
                        </span>
                    @endcan
                    @can('delete', $product)
                        <span class="pull-right">
                            <a class="btn btn-sm btn-danger" href="{{ route('product.destroy', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form').submit();">
								Delete
							</a>

							<form id="delete-form" action="{{ route('product.destroy', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
                        </span>
                    @endcan
                </div>

                <div class="panel-body">
                    <h1>{{ $product->title }}</h1>
                    <small><a href="{{ route('profile.index', ['slug' => $product->user->slug]) }}">{{ $product->user->name }}</a></small>
                    <div>
                        {{ $product->body }}
                    </div>
                </div>
            </div>
            <a href="{{ route('product.index', ['user_slug' => Auth::user()->slug]) }}" class="text-center btn btn-default">Back to list</a>
        </div>
    </div>
</div>
@endsection

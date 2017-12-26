@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom:100px">
    <div class="row">
        <div class="col-md-16 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Product Detail
                    @can('update', $product)
                        <span class="pull-right" style="margin-left:10px">
                            <a href="{{ route('product.edit', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}" class="btn btn-sm btn-primary">Chỉnh sửa</a>
                        </span>
                    @endcan
                    @can('delete', $product)
                        <span class="pull-right">
                            <a class="btn btn-sm btn-danger" href="{{ route('product.destroy', ['user_slug' => Auth::user()->slug, 'slug' => $product->slug]) }}" onclick="event.preventDefault();
                                                     document.getElementById('delete-form').submit();">
								Xóa
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
                        @foreach($product->attachments as $attachment)
                            <img src="{{ url('/images/' . $product->user->uid . '/' . $attachment->original_url) }}">
                        @endforeach
                        <p>
                            {{ $product->body }}
                        </p>
                    </div>
                </div>
            </div>
            @if(Auth::check())
            <a href="{{ route('product.index', ['user_slug' => Auth::user()->slug]) }}" class="text-center btn btn-sm btn-default">Back to list</a>
            @else
            <a href="{{ route('home') }}" class="btn btn-sm btn-default">Back to home</a>
            @endif
        </div>
    </div>
</div>
@endsection

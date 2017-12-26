@extends('layouts.app')
@section('body_class', 'profile-page')

@section('content')

@if(Auth::check() && Auth::user()->id === $user->id)
    <my-profile></my-profile>
@else
    <profile :slug=`{{ $user->slug }}`></profile>
@endif

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @can('update', $user->profile)
                <span class="pull-right">
                    <a href="{{ route('profile.edit', ['user_slug' => $user->slug]) }}" class="btn btn-sm btn-primary">Edit</a>
                </span>
            @endcan
        </div>
    </div>
</div>
@endsection

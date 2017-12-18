@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">            
            <profile :uid="{{ $user->user_code }}"></profile>
            <ul class="permission">
                @foreach($user->permissions->pluck('name') as $permission)
                    <li>{{ $permission }}</li>
                @endforeach
            </ul>
            @can('update', $user->profile)
                <span class="pull-right">
                    <a href="{{ route('profile.edit', ['user_slug' => $user->slug]) }}" class="btn btn-sm btn-primary">Edit</a>
                </span>
            @endcan
        </div>
    </div>
</div>
@endsection

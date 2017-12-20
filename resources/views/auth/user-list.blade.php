@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>UID</th>
                        <th>Email</th>
                        <th>Permissions</th>
                        <th>Roles</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index }}</td>
                            <td><img src="{{ $user->avatar }}" width="52"></td>
                            <td><a href="{{ route('profile.index', ['slug' => $user->slug]) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->uid }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getAllPermissions()->pluck('name') }}</td>
                            <td>{{ $user->getRoleNames() ? $user->getRoleNames() : '' }}</td>
                            <td>
                                <a href="{{ route('profile.edit', ['slug' => $user->slug]) }}" class="btn btn-xs btn-default">Edit</a>
                                <a href="" class="btn btn-xs btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>            
        </div>
    </div>
</div>
@endsection

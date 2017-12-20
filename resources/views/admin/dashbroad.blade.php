@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Dashboard
                    <ul class="list-inline pull-right" style="margin-bottom:0">
                        <li><a class="btn btn-xs btn-default" href="/admin/role">Roles</a></li>
                        <li><a class="btn btn-xs btn-default" href="/admin/permissions">Permissions</a></li>
                    </ul>    
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul>
                        <li>{{ count($data["users"]) }} users</li>
                        <li>{{ count($data['permissions']) }} permissions</li>
                        <li>{{ count($data['roles']) }} roles</li>
                        <li>{{ count($data['products']) }} products</li>
                        <li><a href="/user_list">User List</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

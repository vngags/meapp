@extends('admin.layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
                <form action="{{ route('role.update', ['id' => $role->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="panel-heading clearfix">
                        Edit Role {{ $role->name }}
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label>Role Name:</label>
                            <input type="text" name="role_name" placeholder="Role name" value="{{ $role->name }}">
                        </div>
                        <div class="form-group">
                            <ul class="list-inline">
                                @foreach($permissions as $permission)                                
                                    <li>
                                        <input type="checkbox" 
                                            name="permissions[]" 
                                            id="{{ $permission }}"      
                                            value="{{ $permission }}"
                                            {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}                                                                 
                                        >
                                        <label for="permissions[]">{{ ucfirst($permission)}}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>
@endsection
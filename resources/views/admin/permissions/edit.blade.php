@extends('admin.layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
                <form action="{{ route('permission.update', ['id' => $permission->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="panel-heading clearfix">
                        Edit Permission {{ $permission->name }}
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label>Permission Name:</label>
                            <input type="text" name="permission_name" class="form-control" placeholder="Permission name" value="{{ $permission->name }}">
                        </div>
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
@extends('admin.layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					Permissions
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary pull-right btn-sm" data-toggle="modal" data-target="#permissionModal">
						Create
					</button>
				</div>

				<div class="panel-body">
					<ul>
						@foreach($permissions as $permission)
						<li>{{ $permission->name }}</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <form action="{{route('permission.store')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Create New Permissions</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Permission Name</label>
                        <input type="text" class="form-control input-lg" placeholder="Name, ex: edit-post" name="permission_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
		</div>
	</div>
</div>

@endsection
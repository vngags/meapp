@extends('admin.layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					Rules
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary pull-right btn-sm" data-toggle="modal" data-target="#permissionModal">
						Create
					</button>
				</div>

				<div class="pabel-body">
					<table class="table">
						<tr>
							@foreach($roles as $role)
								<td>
									<table class="table table-hover table-bordered">
										<h4>{{ $role->name }}</h4>
										@foreach($role->permissions->pluck('name') as $permission)							
											<tr><td>{{ $permission }}</td></tr>
										@endforeach
										<td>
											<a href="{{ route('role.edit', ['id' => $role->id]) }}" class="btn btn-xs btn-info">Edit</a>
											<a href="" class="btn btn-xs btn-danger">Delete</a>
										</td>										
									</table>
								</td>
							@endforeach
						</tr>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <form action="{{route('role.store')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Create New Roles</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control input-lg" placeholder="Name, ex: member" name="role_name">
                    </div>
					<div class="form-group">
						<ul class="list-inline">
							@foreach($permissions as $permission)
								<li>								
									<input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
									<label>{{ $permission->name }}</label>
								</li>
							@endforeach
						</ul>
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
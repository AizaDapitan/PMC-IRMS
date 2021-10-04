@extends('layouts.apps')

@section('pagecss')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/select2/select2.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>
@endsection

@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
		{{ $pagename }}
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ route('issuances.index') }}">Issuances</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Maintenance</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ route('users.index') }}">Users</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Edit User</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
	<div class="row">
		<div class="col-md-6">
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>User Form
					</div>
				</div>
				<div class="portlet-body form">
					<!-- BEGIN FORM-->
					<form autocomplete="off" action="{{ route('users.update',$user->id) }}" method="post">
						@method('put')
						@csrf
						<div class="form-body">
							<div class="form-group">
								<label class="control-label">Username</label>
								<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username',$user->username) }}" placeholder="Username">
								@error('username')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="control-label">Email Address</label>
								<input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email',$user->email) }}" placeholder="email@gmail.com">
								@error('email')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="control-label">Location*</label>
								<select name="location" class="bs-select form-control">
									<option @if($user->location == 'MILL') selected @endif value="MILL">Mill</option>
									<option @if($user->location == 'MINES') selected @endif  value="MINES">Mines</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Role*</label>
								<select class="bs-select form-control" name="role_id" id="role_id">
									@foreach($roles as $role)
										<option value="{{ $role['id'] }}" {{ ($role['id'] == $user->role_id) ? 'selected' : '' }} >{{ $role['name'] }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-actions right">
							<button type="submit" class="btn green">Update</button>
							<a href="{{ route('users.index') }}" type="button" class="btn default">Cancel</a>
						</div>
					</form>
					<!-- END FORM-->
				</div>
			</div>
		</div>
	</div>
<!-- END PAGE CONTENT-->
@endsection

@section('pagejs')
	<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>

	<script>
		$('.bs-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
	</script>
@endsection


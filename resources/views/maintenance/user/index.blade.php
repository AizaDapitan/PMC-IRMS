@extends('layouts.apps')

@section('pagecss')
	<link href="{{ asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css"/>
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
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet">
				<div class="portlet-title"></div>
				<div class="portlet-body">
					<div class="table-toolbar">
						<div class="btn-group">
							<div class="dropdown">
								<button type="button" class="btn grey-cascade" data-toggle="dropdown">Sort By <i class="fa fa-angle-down"></i></button>
								<div id="myDropdown" class="dropdown-content dropdown-menu">											
								    <a href="javascript:;" onclick="sortList('username','asc')" @if(app('request')->input('orderBy') == 'username' && app('request')->input('sortBy') == 'asc') style="background-color: #ffb848;" @endif>Name A-Z</a>
								    <a href="javascript:;" onclick="sortList('username','desc')" @if(app('request')->input('orderBy') == 'username' && app('request')->input('sortBy') == 'desc') style="background-color: #ffb848;" @endif>Name Z-A</a>
								    <hr style="margin-top:5px; margin-bottom: 5px; ">
								    <a href="javascript:;" onclick="filterList('location','MILL')" @if(app('request')->input('location') == 'MILL') style="background-color: #ffb848;" @endif>MILL</a>
								    <a href="javascript:;" onclick="filterList('location','MINES')" @if(app('request')->input('location') == 'MINES') style="background-color: #ffb848;" @endif>MINES</a>
								</div>
							</div>
						</div>

						<div class="btn-group pull-right" style="margin-left: 5px;">
							<a class="btn blue" href="{{ route('users.create') }}">Add New User<i class="fa fa-plus"></i></a>
						</div>
						<div class="btn-group pull-right">
							<form id="search_form" class="form-inline">
								<div class="input-group">
									<div class="input-cont">
										<input style="width:250px;" type="search" name="search" id="search" placeholder="Search name" value="{{ app('request')->input('search') }}" class="form-control"/>
									</div>
									<span class="input-group-btn">
										<button type="submit" class="btn green"><i class="m-icon-swapright m-icon-white"></i></button>
									</span>
								</div>
							</form>
						</div>
					</div>
					<div class="table-scrollable">
						<table class="table table-striped table-bordered table-advance table-hover">
							<thead>
							<tr>
								<th>
									<i class="fa fa-briefcase"></i> Name
								</th>
								<th>
									<i class="fa fa-briefcase"></i> Username
								</th>
								<th>
									<i class="fa fa-briefcase"></i> Role
								</th>
								<th class="hidden-xs">
									<i class="fa fa-question"></i> Location
								</th>
								<th>Status</th>
								<th>
									<i class="fa fa-question"></i> Created
								</th>
								<th>
									<i class="fa fa-bookmark"></i> Actions
								</th>
							</tr>
							</thead>
							<tbody>
								@forelse($users as $user)
								<tr>
									<td>{{ $user->name }}</td>
									<td>{{ $user->username }}</td>
									<td>{{ $user->role }}</td>
									<td>{{ $user->location }}</td>
									<td>{{ $user->status }}</td>
									<td>{{ $user->lastdatemodified }}</td>
									<td>
										<a href="#" class="btn btn-xs blue-madison">View</a>
										
										@if($user->status == 'ACTIVE')
										<a href="{{ route('users.edit',$user->id) }}" class="btn btn-xs blue">Edit</a>
										<a href="#" class="btn btn-xs red" onclick="change_status('{{$user->id}}','INACTIVE')">Deactivate</a>
										<a href="#" class="btn btn-xs green" onclick="reset_password('{{$user->id}}')">Reset Password</a>
										@else
										<a href="#" class="btn btn-xs green" onclick="change_status('{{$user->id}}','ACTIVE')">Activate</a>
										@endif
									</td>
								</tr>
								@empty
								<tr><td colspan="6" class="text-center">No users found.</td></tr>
								@endforelse
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-5 col-sm-12">
							@if ($users->firstItem() == null)
		                        <p class="tx-gray-400 tx-12 d-inline">Showing 0 of 0 items</p>
		                    @else
		                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} items</p>
		                    @endif
						</div>
						<div class="col-md-7 col-sm-12">
							<div class="pull-right">
								{{ $users->appends(request()->query())->links() }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END SAMPLE TABLE PORTLET-->
		</div>
	</div>
<!-- END PAGE CONTENT-->
	<div id="user-status" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Confirmation</h4>
		</div>
		<div class="modal-body">
			<p>
				You are about to change the status of the selected user into <b><span id="user_status"></span></b>. Do you want to continue?
			</p>
		</div>
		<form method="post" action="{{ route('user.change-status') }}">
			@csrf
			<div class="modal-footer">
				<input type="hidden" name="userid" id="userid">
				<input type="hidden" name="userstatus" id="userstatus">
				<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn" id="btnStatus">Yes, <span id="status_btn"></span>!</button>
			</div>
		</form>
	</div>

	<div id="reset-password" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Confirmation</h4>
		</div>
		<div class="modal-body">
			<p>
				You are about to reset the user password. Do you want to continue?
			</p>
		</div>
		<form method="post" action="{{ route('user.reset-password') }}">
			@csrf
			<div class="modal-footer">
				<input type="hidden" name="userid" id="ruserid">
				<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn red">Yes, reset!</button>
			</div>
		</form>
	</div>
@endsection

@section('pagejs')
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
	<script>
        let listingUrl = "{{ route('users.index') }}";
    </script>
@endsection

@section('customjs')
	<script>
		function sortList(orderby,sortby){
			var search = $('#search').val();
			window.location.href = listingUrl + "?orderBy="+orderby+"&sortBy="+sortby+"&search="+search;
		}

		function filterList(column,value){
			window.location.href = listingUrl + "?"+column+"="+value;
		}

		$('#search_form').submit(function(){
			var search = $('#search').val();

			if(search.length === 0){
				window.location.href = listingUrl;
			} else {
				window.location.href = listingUrl + "?search="+search;
			}
		});

		function reset_password(id){
			$('#ruserid').val(id);
			$('#reset-password').modal('show');
		}

		function change_status(id,status){
			$('#userid').val(id);
			$('#userstatus').val(status);
			$('#user_status').html(status);

			if(status == 'ACTIVE'){
				$('#status_btn').html('activate');
				$('#btnStatus').addClass('green');
				$('#btnStatus').removeClass('red');
			} else {
				$('#status_btn').html('deactivate');
				$('#btnStatus').addClass('red');
				$('#btnStatus').removeClass('green');
			}

			$('#user-status').modal('show');
		}
	</script>
@endsection
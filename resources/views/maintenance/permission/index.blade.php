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
				<a href="{{ route('permissions.index') }}">Permissions</a>
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
										
									    <a href="javascript:;" onclick="sortList('module_type','asc')" @if(app('request')->input('orderBy') == 'module_type' && app('request')->input('sortBy') == 'asc') style="background-color: #ffb848;" @endif>Module Type A-Z</a>
									    <a href="javascript:;" onclick="sortList('module_type','desc')" @if(app('request')->input('orderBy') == 'module_type' && app('request')->input('sortBy') == 'desc') style="background-color: #ffb848;" @endif>Module Type Z-A</a>
									    <hr style="margin-top:5px; margin-bottom: 5px; ">
									    <a href="javascript:;" onclick="sortList('description','asc')" @if(app('request')->input('orderBy') == 'description' && app('request')->input('sortBy') == 'asc') style="background-color: #ffb848;" @endif>Description A-Z</a>
									    <a href="javascript:;" onclick="sortList('description','desc')" @if(app('request')->input('orderBy') == 'description' && app('request')->input('sortBy') == 'desc') style="background-color: #ffb848;" @endif>Description Z-A</a>
									  </div>
								</div>
						</div>

						<div class="btn-group pull-right" style="margin-left: 5px;">
							<a class="btn blue" data-toggle="modal" href="#basic" onclick="addPermission()"> Add New </a>						
						</div>
						<div class="btn-group pull-right">
							<form id="search_form" class="form-inline">
								<div class="input-group">
									<div class="input-cont">
										<input style="width:250px;" type="search" name="search" id="search" placeholder="Input Description" value="{{ app('request')->input('search') }}" class="form-control"/>
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
									<i class="fa fa-briefcase"></i> Module
								</th>
								<th>
									<i class="fa fa-briefcase"></i> Description
								</th>
								<th>
									<i class="fa fa-briefcase"></i> Status
								</th>                                
								<th>
									<i class="fa fa-bookmark"></i> Actions
								</th>
							</tr>
							</thead>
							<tbody>
								@forelse($permissions as $permission)
									<tr id="row{{$permission->id}}">
										<td>
											{{ strtoupper($permission['module_type']) }}
										</td>
                                        <td>{{ ($permission->description) }}</td>                
                                        <td> 
                                            @if($permission->active)
                                            <i class="font-blue"> Active</i>
                                            @else
                                            <i class="font-red"> Inactive</i>
                                            @endif
                                        </td>

										<td>
											<a href="#" class="btn default btn-xs blue" onclick="update_permission('{{$permission->id}}','{{$permission->module_type}}','{{$permission->description}}','{{$permission->active}}')">Edit </a>
										</td>
									</tr>
								@empty
									<tr><td colspan="5" class="text-center">No permissions found</td></tr>
								@endforelse
							</tbody>
						</table>
					</div>

					<div class="row">
						<div class="col-md-5 col-sm-12">
							@if ($permissions->firstItem() == null)
		                        <p class="tx-gray-400 tx-12 d-inline">Showing 0 of 0 items</p>
		                    @else
		                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $permissions->firstItem() }} to {{ $permissions->lastItem() }} of {{ $permissions->total() }} items</p>
		                    @endif
						</div>
						<div class="col-md-7 col-sm-12">
							<div class="pull-right">
								{{ $permissions->appends(request()->query())->links() }}
							</div>
						</div>
					</div>					

				</div>
			</div>
			<!-- END SAMPLE TABLE PORTLET-->
		</div>
	</div>
<!-- END PAGE CONTENT-->


	<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Add New Permission</h4>
		</div>

		<form id="form" role="form" action="{{ route('permissions.store') }}" method="POST">
			@csrf

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">

						<label class="control-label">Status</label>
						<p>
							<input type="checkbox" name="active" id="active">
						</p>

						<label class="control-label">Module <span class="required" aria-required="true"> * </span></label>
						<p>
                            <select required name="module_type" id="module_type" class="form-control"> 
                                @foreach($modules as $module)
                                    <option value="{{ $module['description'] }}">{{ $module['description'] }}</option>
                                @endforeach
                            </select>
						</p>

						<label class="control-label">Description <span class="required" aria-required="true"> * </span></label>
						<p>
							<input type="text" class="form-control" id="description" name="description" placeholder="Description" required maxlength="50">
						</p>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
				<button type="submit" class="btn green"><i class="fa fa-check"></i> Save Permission</button>
			</div>
			
		</form>
	</div>


	<div id="update-permission" class="modal fade" tabindex="-1">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Update Permission</h4>			
		</div>
		<form method="post" action="{{ route('permission.update') }}">
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<input type="hidden" name="nameid" id="nameid">

						<label class="control-label">Status</label>
						<p>
							<input type="checkbox" name="eactive" id="eactive">
						</p>						
						
						<label class="control-label">Module <span class="required" aria-required="true"> * </span></label>
						<p>
                            <select required name="module_type" id="emodule_type" class="form-control"> 
                                @foreach($modules as $module)
                                    <option value="{{ $module['description'] }}">{{ $module['description'] }}</option>
                                @endforeach
                            </select>

						</p>

						<label class="control-label">Description <span class="required" aria-required="true"> * </span></label>
						<p>							
							<input class="form-control" type="text" name="description" id="edescription" placeholder="Description" required maxlength="50">
						</p>						


					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
				<button type="submit" class="btn green"><i class="fa fa-check"></i> Update Permission</button>
			</div>
		</form>
	</div>

	@include('common-modals')
@endsection

@section('pagejs')
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
	<script>
        let listingUrl = "{{ route('permissions.index') }}";
    </script>
@endsection

@section('customjs')
	<script type="text/javascript">

		function sortList(orderby,sortby)
		{
			var search = $('#search').val();
			window.location.href = listingUrl + "?orderBy="+orderby+"&sortBy="+sortby+"&search="+search;
		}

		$('#search_form').submit(function()
		{
			var search = $('#search').val();

			if(search.length === 0){
				window.location.href = listingUrl;
			} else {
				window.location.href = listingUrl + "?search="+search;
			}
		});

		$(document).ready(function() 
		{
			document.getElementById('active').checked = true;
		});		

		function addPermission() 
		{										
			$('#nameid').val('');
			$('#module_type').val('');
			$('#description').val('');			
		}

		function update_permission(id,module_type,description,status)
		{
			if (status == "1")
			{				
				document.getElementById('eactive').checked = true;
			}
			else
			{
				document.getElementById('eactive').checked = false;
			}

			$('#nameid').val(id);			
			$('#emodule_type').val(module_type);
			$('#edescription').val(description);
			$('#update-permission').modal('show');
		}

	</script>
@endsection
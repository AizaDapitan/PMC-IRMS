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
				<a href="{{ route('ppe-items.index') }}">PPE Items</a>
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
										
									    <a href="javascript:;" onclick="sortList('category','asc')" @if(app('request')->input('orderBy') == 'category' && app('request')->input('sortBy') == 'asc') style="background-color: #ffb848;" @endif>Name A-Z</a>
									    <a href="javascript:;" onclick="sortList('category','desc')" @if(app('request')->input('orderBy') == 'category' && app('request')->input('sortBy') == 'desc') style="background-color: #ffb848;" @endif>Name Z-A</a>
									    <hr style="margin-top:5px; margin-bottom: 5px; ">
									    <a href="javascript:;" onclick="sortList('updated_at','asc')" @if(app('request')->input('orderBy') == 'updated_at' && app('request')->input('sortBy') == 'asc') style="background-color: #ffb848;" @endif>Date Modified ASC</a>
									    <a href="javascript:;" onclick="sortList('updated_at','desc')" @if(app('request')->input('orderBy') == 'updated_at' && app('request')->input('sortBy') == 'desc') style="background-color: #ffb848;" @endif>Date Modified DESC</a>
									  </div>
								</div>
						</div>
						<div class="btn-group">
							@if($delete)
								<button class="btn default dropdown-toggle" data-toggle="dropdown">Actions <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu">
									<li>
											<a href="#" onclick="delete_categories()"><i class="fa fa-trash-o"></i> Delete</a>
									</li>
								</ul>
							@else
								<button disabled class="btn default dropdown-toggle" data-toggle="dropdown">Actions <i class="fa fa-angle-down"></i> </button>
							@endif
						</div>

						<div class="btn-group pull-right" style="margin-left: 5px;">
							@if($create)
								<button class="btn blue" data-toggle="modal" href="#add-category">Add New <i class="fa fa-plus"></i></button>
							@else
								<button disabled class="btn blue" data-toggle="modal" href="#add-category">Add New <i class="fa fa-plus"></i></button>
							@endif
						</div>
						<div class="btn-group pull-right">
							<form id="search_form" class="form-inline">
								<div class="input-group">
									<div class="input-cont">
										<input style="width:250px;" type="search" name="search" id="search" placeholder="Input Name" value="{{ app('request')->input('search') }}" class="form-control"/>
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
								<th width="5%">
									<input type="checkbox" id="select_all">
								</th>
								<th>
									<i class="fa fa-briefcase"></i> Name
								</th>
								<th class="hidden-xs">
									<i class="fa fa-question"></i> Last Date Modified
								</th>
								<th>
									<i class="fa fa-question"></i> Added By
								</th>
								<th>
									<i class="fa fa-bookmark"></i> Actions
								</th>
							</tr>
							</thead>
							<tbody>
								@forelse($categories as $category)
									<tr id="row{{$category->id}}">
										<td>
											<input type="checkbox" class="cb" id="cb{{ $category->id }}"/>
										</td>
										<td>
											{{ $category->category }}
										</td>
										<td class="hidden-xs">
											{{ $category->lastdatemodified }}
										</td>
										<td>
											{{ $category->addedBy }}
										</td>
										<td>
											@if($edit)
												<a href="#" class="btn default btn-xs blue" onclick="update_category('{{$category->id}}','{{$category->category}}')">Edit </a>
											@else
												<button disabled href="#" class="btn default btn-xs blue" >Edit </button>
											@endif
											@if($delete)
												<a href="#" class="btn default btn-xs red" onclick="category_delete('{{$category->id}}')">Delete </a>
											@else
												<button disabled href="#" class="btn default btn-xs red" >Delete </button>
											@endif
										</td>
									</tr>
								@empty
									<tr><td colspan="5" class="text-center">No categories found</td></tr>
								@endforelse
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-5 col-sm-12">
							@if ($categories->firstItem() == null)
		                        <p class="tx-gray-400 tx-12 d-inline">Showing 0 of 0 items</p>
		                    @else
		                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} items</p>
		                    @endif
						</div>
						<div class="col-md-7 col-sm-12">
							<div class="pull-right">
								{{ $categories->appends(request()->query())->links() }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END SAMPLE TABLE PORTLET-->
		</div>
	</div>
<!-- END PAGE CONTENT-->

	<div id="add-category" class="modal fade" tabindex="-1">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Add New Item</h4>
		</div>
		<form autocomplete="off" method="post" action="{{ route('ppe-items.store') }}">
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label>Name *</label>
						<p>
							<input required class="form-control" type="text" name="name" id="name" required maxlength="90">
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
				<button type="submit" class="btn green"><i class="fa fa-check"></i> Save Item</button>
			</div>
		</form>
	</div>

	<div id="update-category" class="modal fade" tabindex="-1">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Update Item</h4>
		</div>
		<form method="post" action="{{ route('ppe-category.update') }}">
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label>Name *</label>
						<p>
							<input type="hidden" name="catid" id="catid">
							<input required class="form-control" type="text" name="name" id="ename" required maxlength="90">
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
				<button type="submit" class="btn green"><i class="fa fa-check"></i> Update Item</button>
			</div>
		</form>
	</div>

	<div id="category-delete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Confirmation</h4>
		</div>
		<div class="modal-body">
			<p>
				You are about to delete this item. Do you want to continue?
			</p>
		</div>
		<form method="post" action="{{ route('ppe-category.delete') }}">
			@csrf
			<div class="modal-footer">
				<input type="hidden" name="catid" id="dcatid">
				<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
				<button type="submit" 	class="btn red">Yes, delete!</button>
			</div>
		</form>
	</div>
	<div id="multiple-delete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	        <h4 class="modal-title">Confirmation</h4>
	    </div>
	    <div class="modal-body">
	        <p>
	            You are about to delete this item. Do you want to continue?
	        </p>
	    </div>
	    <form method="post" action="{{ route('ppe-category.multiple-delete') }}">
	        @csrf
	        <div class="modal-footer">
	            <input type="hidden" name="id" id="item-id">
	            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
	            <button type="submit"   class="btn red">Yes, delete!</button>
	        </div>
	    </form>
	</div>

	@include('common-modals')
@endsection

@section('pagejs')
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
	<script>
        let listingUrl = "{{ route('ppe-items.index') }}";
    </script>
@endsection

@section('customjs')
	<script>
		function sortList(orderby,sortby){
			var search = $('#search').val();
			window.location.href = listingUrl + "?orderBy="+orderby+"&sortBy="+sortby+"&search="+search;
		}

		$('#search_form').submit(function(){
			var search = $('#search').val();

			if(search.length === 0){
				window.location.href = listingUrl;
			} else {
				window.location.href = listingUrl + "?search="+search;
			}
		});

		$('#add-category').on('shown.bs.modal', function () {
		    $('#name').focus();
		});  

		function update_category(id,category){
			$('#catid').val(id);
			$('#ename').val(category);
			$('#update-category').modal('show');
		}

		function category_delete(id){
			$('#dcatid').val(id);
			$('#category-delete').modal('show');
		}

		/*** handles the changing of status of multiple pages ***/
        function delete_categories(){

            var counter = 0;
            var selected_category = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_category += fid.substring(2, fid.length)+'|';
            });
            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
            	$('#item-id').val(selected_category);
                $('#multiple-delete').modal('show');
            }
        }

		/*** Handles the Select All Checkbox ***/
        $("#select_all").click(function(){
            $('.cb').not(this).prop('checked', this.checked);
        });
	</script>
@endsection
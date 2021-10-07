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
								    <a href="javascript:;" onclick="sortList('controlNum','asc')" @if(app('request')->input('orderBy') == 'controlNum' && app('request')->input('sortBy') == 'asc') style="background-color: #ffb848;" @endif>Control Number ASC</a>
								    <a href="javascript:;" onclick="sortList('controlNum','desc')" @if(app('request')->input('orderBy') == 'controlNum' && app('request')->input('sortBy') == 'desc') style="background-color: #ffb848;" @endif>Control Number DESC</a>
								    
								    <hr style="margin-top:5px; margin-bottom: 5px; ">
								    <a href="javascript:;" onclick="sortList('dept','asc')" @if(app('request')->input('orderBy') == 'dept' && app('request')->input('sortBy') == 'asc') style="background-color: #ffb848;" @endif>Department ASC</a>
								    <a href="javascript:;" onclick="sortList('dept','desc')" @if(app('request')->input('orderBy') == 'dept' && app('request')->input('sortBy') == 'desc') style="background-color: #ffb848;" @endif>Department DESC</a>

								    <hr style="margin-top:5px; margin-bottom: 5px; ">
								    <a href="javascript:;" onclick="filterList('location','mill')" @if(app('request')->input('location') == 'mill') style="background-color: #ffb848;" @endif>Mill</a>
								    <a href="javascript:;" onclick="filterList('location','mines')" @if(app('request')->input('location') == 'mines') style="background-color: #ffb848;" @endif>Mines</a>

								    <hr style="margin-top:5px; margin-bottom: 5px; ">
								    <a href="javascript:;" onclick="filterList('type','1')" @if(app('request')->input('type') == '1') style="background-color: #ffb848;" @endif>Contractors</a>
								    <a href="javascript:;" onclick="filterList('type','0')" @if(app('request')->input('type') == '0') style="background-color: #ffb848;" @endif>Employees</a>
								</div>
							</div>
						</div>

						<div class="btn-group pull-right" style="margin-left: 5px;">
							@if($create)
								<a class="btn blue" href="{{ route('issuances.create') }}">Add New <i class="fa fa-plus"></i></a>
							@else
								<button disabled class="btn blue" href="{{ route('issuances.create') }}">Add New <i class="fa fa-plus"></i></a>
							@endif
						</div>
						<div class="btn-group pull-right">
							<form id="search_form" class="form-inline">
								<div class="input-group">
									<div class="input-cont">
										<input style="width:270px;" type="search" name="search" id="search" placeholder="Input Control #,Receiver or Recipient" value="{{ app('request')->input('search') }}" class="form-control"/>
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
								<th width="5%">Control #</th>
								<th width="20">Recipient</th>
								<th width="10%">Position</th>
								<th width="10%">Department</th>
								<th width="7%">Document Date</th>
								<th width="13%">Receiver</th>
								<th width="5%">Location</th>
								<th width="10%">Status</th>
								<th width="20%">Actions</th>
							</tr>
							</thead>
							<tbody>
								@forelse($issuances as $issuance)
									<tr>
										<td>{{ $issuance->controlNum }}</td>
										<td class="@if($issuance->isContractor == 1) text-success @else text-primary @endif">
											{{ $issuance->receiver }}
										</td>
										<td>{{ $issuance->position }}</td>
										<td>
											@if($issuance->isContractor <> 1)
											{{ $issuance->dept }}
											@endif
										</td>
										<td>{{ $issuance->docDate }}</td>
										<td>
											@if($issuance->isContractor >= 1)
												{{ $issuance->receiverId }}
											@endif
										</td>
										<td>{{ $issuance->location }}</td>
										<td>{!! $issuance->requeststatus !!}</td>
										<td>
											<a href="#" class="btn btn-xs blue-madison" onclick="$('#detailsd{{$issuance->id}}').toggle()">View</a>
											@if($print)
												<a href="{{ route('issuance-print',$issuance->id) }}" target="_blank" class="btn btn-xs green-meadow">Print</a>
											@else
												<button disabled target="_blank" class="btn btn-xs green-meadow">Print</button>
											@endif
											@if($issuance->status == 'P')
												@if($issuance->issuancestatus == 0)
												@if($edit)
													<a href="{{ route('issuances.edit',$issuance->id) }}" class="btn btn-xs blue">Edit</a>
												@else
													<button disabled class="btn btn-xs blue">Edit</button>
												@endif
												@if($delete)
													<a href="#" class="btn btn-xs red" onclick="cancel_issuance('{{$issuance->id}}','{{$issuance->controlNum}}')">Cancel</a>
												@else
													<button disabled class="btn btn-xs red">Cancel</button>
												@endif
												@endif
											@endif
										</td>
									</tr>
									<tr>
	                                    <td colspan="9" class="detailsd" id="detailsd{{$issuance->id}}" style='display:none;'>
	                                    	<div class="portlet box grey-cascade">
												<div class='portlet-title'>
													<div class="caption">
														<i class="fa fa-globe"></i>Control# {{$issuance->controlNum}}
													</div>
												</div>
												<div class="portlet-body">
													<table width="80%" class="table table-condensed table-hover">
														<tr>
															<th>Item</th>							
															<th>Size</th>
															<th>Color</th>
															<th>Last Issue</th>
															<th>Remarks</th>
															<th>Qty</th>
															<th>Status</th>
															<th>Reference</th>
														</tr>
														@foreach($issuance->items as $item)
														<tr>
															<td>{{ $item->itemDesc }}</td>
															<td>{{ $item->itemSize }}</td>
															<td>{{ $item->itemColor }}</td>
															<td>{{ $item->lastIssueDate }}</td>
															<td>{{ $item->remarks }}</td>
															<td>{{ $item->qty }}</td>
															<td>{{ $item->qtyReleased }}/{{ $item->qty }}</td>
															<td>{{ $item->systemref }}</td>
														</tr>
														@endforeach
													</table>
												</div>
											</div>
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="9" class="text-center">No issuance request found.</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-5 col-sm-12">
							@if ($issuances->firstItem() == null)
		                        <p class="tx-gray-400 tx-12 d-inline">Showing 0 of 0 items</p>
		                    @else
		                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $issuances->firstItem() }} to {{ $issuances->lastItem() }} of {{ $issuances->total() }} items</p>
		                    @endif
						</div>
						<div class="col-md-7 col-sm-12">
							<div class="pull-right">
								{{ $issuances->appends(request()->query())->links() }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END SAMPLE TABLE PORTLET-->
		</div>
	</div>
<!-- END PAGE CONTENT-->

	<div id="issuance-cancel" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Confirmation</h4>
		</div>
		<div class="modal-body">
			<p>
				You are about to delete this control # <b><span id="issuance_controlno"></span></b>. Do you want to continue?
			</p>
		</div>
		<form method="post" action="{{ route('issuance.cancel') }}">
			@csrf
			<div class="modal-footer">
				<input type="hidden" name="issuanceid" id="issuanceid">
				<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
				<button type="submit" 	class="btn red">Yes, cancel!</button>
			</div>
		</form>
	</div>
@endsection

@section('pagejs')
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
	<script>
        let listingUrl = "{{ route('issuances.index') }}";
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

		function cancel_issuance(id,controlno){
			$('#issuanceid').val(id);
			$('#issuance_controlno').html(controlno);
			$('#issuance-cancel').modal('show');
		}

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
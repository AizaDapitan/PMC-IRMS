@extends('layouts.apps')

@section('pagecss')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/select2/select2.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}"/>

	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/clockface/css/clockface.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css') }}"/>

	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/sweetalert/sweetalert.min.css') }}"/>
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
				<a href="#">Edit Issuance</a>
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
			<hr style="margin-top: 0px;">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>Issuance Request Form
					</div>
				</div>
				<div class="portlet-body form">
					<!-- BEGIN FORM-->
					<form id="issuance_form" action="{{ route('issuances.update',$issuance->id) }}" method="post" class="horizontal-form">
						@method('put')
						@csrf
						<div class="form-body">
							<h3 class="form-section">Issuance Details</h3>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Document Date*</label>
										<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
											<input type="text" class="form-control" name="docdate" id="docdate" readonly value="{{ $issuance->docDate }}">
											<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
										<span class="text-danger" id="span_docdate" style="display: none;">Document date field is required.</span>
									</div>
								</div>
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Issuance Type</label>
										<select class="bs-select form-control" name="issuance_type" id="issuance_type">
											<option @if($issuance->isContractor == 0) selected @endif value="employee">Employee</option>
											<option @if($issuance->isContractor == 2) selected @endif value="department">Department</option>
											<option @if($issuance->isContractor == 1) selected @endif value="contractor">Contractor</option>
										</select>
									</div>
									<input type="hidden" id="iss_type" value="{{$issuance->isContractor}}">
								</div>
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-4" id="divEmployee" @if($issuance->isContractor == 0) style="display:block;" @else style="display:none;" @endif>
									<div class="form-group">
										<label class="control-label">Employee*</label>
										<input required name="test" type="hidden" id="select2_employee" class="form-control select2">
										<input type="hidden" name="employee" id="employee" value="{{$issuance->receiverId}} : {{ $issuance->receiver }}">
										<span class="text-danger" id="span_employee" style="display: none;">Employee field is required.</span>
									</div>
								</div>
							</div>
							<!--/row-->

							<div class="row" id="divDept" @if($issuance->isContractor == 2) style="display:block;" @else style="display:none;" @endif>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Department*</label>
										<select class="form-control select2me" name="department" id="department">
											@php $arr_dept = []; @endphp
											@foreach($departments as $dept)

												@if(!in_array($dept['DeptDesc'],$arr_dept))
													@php array_push($arr_dept, $dept['DeptDesc']) @endphp
													<option @if($issuance->receiver == $dept['DeptDesc']) selected @endif value="{{ $dept['DeptDesc'] }}">{{ $dept['DeptDesc'] }}</option>
												@endif

											@endforeach
										</select>
										<span class="text-danger" id="span_department" style="display: none;">Department field is required.</span>
									</div>
								</div>
							</div>
							<!--/row-->
								
							<div class="row" id="divContractor" @if($issuance->isContractor == 1) style="display:block;" @else style="display:none;" @endif>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Contractor*</label>
										<input type="hidden" id="select2_contractor" class="form-control select2">
										<input type="hidden" name="contractor" id="contractor" value="{{ $issuance->receiver }}">
										<span class="text-danger" id="span_contractor" style="display: none;">Contractor field is required.</span>
										<input type="hidden" name="contractorid" id="contractorid" value="{{ $issuance->dept }}">
									</div>
								</div>
							</div>
							<!--/row-->
							<div class="row" id="divReceiver" @if($issuance->isContractor == 0) style="display:none;" @else style="display:block;" @endif>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Receiver*</label>
										<input type="text" name="receiver" id="receiver" class="form-control" value="@if($issuance->isContractor > 0) {{ $issuance->receiverId }} @endif" required maxlength="50">
										<span class="text-danger" id="span_receiver" style="display: none;">Receiver field is required.</span>
									</div>
								</div>
							</div>
							<!--/row-->
							<h3 class="form-section">PPE Items</h3>
							<div class="row">
								<div class="form-group">
									<div class="col-md-4">
										<select class="form-control select2me" name="item" id="add_ppeitem">
											@foreach($items as $item)
											<option value="{{ $item->category }}">{{ $item->category }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-1">
										<button type="button" class="btn blue" onclick="add_item()">+</button>
									</div>
								</div>
							</div>
							<br>

								<div class="alert alert-info">
									<strong>Note:</strong>
									Items with with highlighted blue color are items that are already added in the issuance detail.
								</div>
							<table class="table table-bordered table-stripped">
								<thead>
									<th width="30%">Item</th>
									<th width="15%">Type</th>
									<th width="10%">Quantity</th>
									<th width="15%">Last Issued Date</th>
									<th width="25%">Remarks</th>
									<th width="5%"></th>
								</thead>
								<tbody id="items_tbl">
									@php $lastid = 0; $totalitem = 0; @endphp
									@foreach($issuance->items as $item)

									@php $lastid = $loop->iteration; $totalitem++; @endphp
									<tr id="row{{$loop->iteration}}">
				                		<td>
				                			<input type="hidden" name="detailid[]" value="{{$item->id}}">
				                			<input type="hidden" class="itemid" name="itemid[]" value="{{$loop->iteration}}">
				                			<input style="border: 1px solid blue;" type="text" name="name[]" class="form-control" value="{{$item->itemDesc}}" readonly>
				                		</td>
				                		<td>
				                			<select required class="form-control" name="type[]">
				                				@if(count($item->item_types))
				                					@foreach($item->item_types as $type)
					                				<option>{{$type->type}}</option>
					                				@endforeach
				                				@else
				                					<option value="None">None</option>
				                				@endif
				                			</select>
				                		</td>
				                		<td><input type="number" name="qty[]" class="form-control text-right" value="{{$item->qty}}" min="1"></td>
				                		<td>
											<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-end-date="-1d">
												<input required type="text" name="issuedate[]" class="form-control" style="width: 250px;" readonly value="{{$item->lastissuedate}}">
												<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</td>
										<td><input required  type="text" name="remarks[]" class="form-control" value="{{$item->remarks}}"></td>
										<td><button type="button" class="btn red" onclick="remove_item('{{$item->id}}','{{$item->itemDesc}}')">x</button></td>
									</tr>
									@endforeach
								</tbody>
							</table>
							<input type="hidden" id="totalitem" value="{{$totalitem}}">
							<input type="hidden" id="lastid" value="{{ $lastid }}">
						</div>
						<div class="form-actions right">
							<a href="{{ route('issuances.index') }}" class="btn default">Cancel</a>
							<button type="submit" class="btn green"><i class="fa fa-check"></i> Update</button>
						</div>
					</form>
					<!-- END FORM-->
				</div>
			</div>
			<!-- END SAMPLE TABLE PORTLET-->
		</div>
	</div>
<!-- END PAGE CONTENT-->
	<div id="remove-item" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Confirmation</h4>
		</div>
		<div class="modal-body">
			<p>
				You are about to delete this item name <b><span id="itemname"></span></b>. Do you want to continue?
			</p>
		</div>
		<form method="post" action="{{ route('issuance.remove-item') }}">
			@csrf
			<div class="modal-footer">
				<input type="hidden" name="issuanceid" id="issuanceid">
				<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
				<button type="submit" 	class="btn red">Yes, remove!</button>
			</div>
		</form>
	</div>
@endsection

@section('pagejs')
	<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"></script>

	<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/clockface/js/clockface.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('assets/global/plugins/sweetalert/sweetalert.min.js') }}"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
	<script>
		$('.date-picker').datepicker({
		   	rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true
	   	});

	   	$('.bs-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
	</script>
@endsection

@section('customjs')
	<script>

		$('#issuance_type').change(function(){
			var type = $(this).val();

			if(type == 'department'){
				$('#divDept').css('display','block');
				$('#divReceiver').css('display','block');

				$('#divEmployee').css('display','none');
				$('#divContractor').css('display','none');
			}

			if(type == 'contractor'){
				$('#divContractor').css('display','block');
				$('#divReceiver').css('display','block');

				$('#divEmployee').css('display','none');
				$('#divDept').css('display','none');
			}

			if(type == 'employee'){
				$('#divEmployee').css('display','block');
				$('#divReceiver').css('display','block');

				$('#divDept').css('display','none');
				$('#divContractor').css('display','none');
				$('#divReceiver').css('display','none');
			}
		});

		$('#issuance_form').submit(function(){
			var docdate  = $('#docdate').val();
			var employee = $('#employee').val();
			var contractor = $('#contractor').val();
			var receiver = $('#receiver').val();
			var department = $('#department').val();


			var type = $('#issuance_type').val();

			if(docdate.length === 0){
				$('#span_docdate').css('display','block');
			} else {
				$('#span_docdate').css('display','none');
			}

			var totalitems = 0;
			$(".itemid").each(function() {
                totalitems++
            });


			if(type == 'employee'){
				if(employee.length === 0){
					$('#span_employee').css('display','block');
				} else {
					$('#span_employee').css('display','none');
				}

				if(docdate.length === 0 || employee.length === 0){
					return false;
				} else {
					if(totalitems > 0){
						return true;
					} else {
						swal({
		                    title: '',
		                    text: "Please select at least one(1) item.",         
		                });

		                return false;
					}
				}
			}

			if(type == 'department'){
				if(department.length === 0){
					$('#span_department').css('display','block');
				} else {
					$('#span_department').css('display','none');
				}

				if(receiver.length === 0){
					$('#span_receiver').css('display','block');
				} else {
					$('#span_receiver').css('display','none');
				}

				if(docdate.length === 0 || receiver.length === 0 || department.length === 0){
					return false;
				} else {
					if(totalitems > 0){
						return true;
					} else {
						swal({
		                    title: '',
		                    text: "Please select at least one(1) item.",         
		                });

		                return false;
					}
				}
			}

			if(type == 'contractor'){
				if(contractor.length === 0){
					$('#span_contractor').css('display','block');
				} else {
					$('#span_contractor').css('display','none');
				}

				if(receiver.length === 0){
					$('#span_receiver').css('display','block');
				} else {
					$('#span_receiver').css('display','none');
				}

				if(docdate.length === 0 || receiver.length === 0 || contractor.length === 0){
					return false;
				} else {
					if(totalitems > 0){
						return true;
					} else {
						swal({
		                    title: '',
		                    text: "Please select at least one(1) item.",         
		                });

		                return false;
					}
				}
			}
		});
 
		function add_item(){
			var i = $('#lastid').val(); 
			var item = $('#add_ppeitem').val();

			$.ajax({
                data: {
                    "item": item,
                    "_token": "{{ csrf_token() }}",
                },
                type: "GET",
                url: "{{route('ajax-get-ppe-item-details')}}",
                success: function(response) {
                	i++;
                	$('#lastid').val(i);
                	swal({
                        title: '',
                        text: "Selected PPE item has been added.",         
                    });

                	$('#items_tbl').append(
                		'<tr id="row'+i+'">'+
	                		'<td>'+
	                			'<input type="hidden" name="detailid[]" value="0">'+
	                			'<input type="hidden" class="itemid" name="itemid[]" value="'+i+'">'+
	                			'<input type="text" name="name[]" class="form-control" value="'+response.item['category']+'" readonly>'+
	                		'</td>'+
	                		'<td><select required class="form-control" name="type[]" id="type_'+i+'"></select></td>'+
	                		'<td><input type="number" name="qty[]" class="form-control text-right" value="1" min="1"></td>'+
	                		'<td>'+
									'<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">'+
										'<input required type="text" name="issuedate[]" class="form-control" style="width: 250px;" readonly>'+
										'<span class="input-group-btn">'+
										'<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>'+
										'</span>'+
									'</div>'+
							'</td>'+
							'<td><input required  type="text" name="remarks[]" class="form-control"></td>'+
							'<td><button type="button" class="btn red btn_remove" id="'+i+'">x</button></td>'+
						'</tr>');

                	if(response.count > 0){
                		$.each(response.types, function(key, value) {
	                        $('#type_'+i).append('<option value="'+value.type+'">'+value.type+'</option>');
	                    });
                	} else {
                		$('#type_'+i).append('<option value="None">None</option>');
                	}
                	

                	$('.date-picker').datepicker({
					   	rtl: Metronic.isRTL(),
			            orientation: "left",
			            autoclose: true
				   	});
                }
            });
		}
		$(document).on('click', '.btn_remove', function(){
			var lastid = $('#lastid').val();
			if(lastid == 1){
				swal({
	                title: '',
	                text: "Issuance request must have at least one(1) item.",         
	            });
			} else {
				var x = parseInt(lastid)-1;
				$('#lastid').val(x);

	           	var id = $(this).attr("id");   
	           	$('#row'+id+'').remove();  
			}
        });

		function employeeFormatResult(employee) {
			
            var result = "<table class='movie-result'><tr>";

            result += "<td valign='top'>"+employee.EmpID+" : "+employee.LName+", "+employee.FName+" "+employee.MName+"</td>";

            result += "</tr></table>"
            return result;
        }

        function employeeFormatSelection(employee) {
        	$('#employee').val(employee.EmpID+" : "+employee.LName+", "+employee.FName+" "+employee.MName);
            return employee.EmpID+" : "+employee.LName+", "+employee.FName+" "+employee.MName;
        }

		$("#select2_employee").select2({
            placeholder: "Search for a PMC employee",
            minimumInputLength: 3,
            ajax: {
                url: "{{ route('ajax-employees') }}",
                type: 'GET',
                data: function (term) {
                    return {
                        q: term,
                    };
                },
                results: function (response) { 
                    return {
                        results: response
                    };
                }
            },
            id: function(e){
            	return e.EmpID;
            },
            formatResult: employeeFormatResult,
            formatSelection: employeeFormatSelection,
            dropdownCssClass: "bigdrop",
            escapeMarkup: function (m) {
                return m;
            }
        });

        function contractorFormatResult(contractor) {
			
            var result = "<table class='movie-result'><tr>";

            if(contractor.code){
            	var ccode = contractor.code+' - ';
            } else {
            	var ccode = '';
            }

            if(contractor.fname){
            	var cfname = contractor.fname;
            } else {
            	var cfname = '';
            }

            result += "<td valign='top'>"+ccode+contractor.lname+", "+cfname+"</td>";

            result += "</tr></table>"
            return result;
        }

        function contractorFormatSelection(contractor) {
        	if(contractor.code){
            	var ccode = contractor.code+' - ';
            } else {
            	var ccode = '';
            }

            if(contractor.fname){
            	var cfname = contractor.fname;
            } else {
            	var cfname = '';
            }
            
        	$('#contractorid').val(contractor.id);
        	$('#contractor').val(ccode+contractor.lname+", "+cfname);

            return ccode+contractor.lname+", "+cfname;
        }

		$("#select2_contractor").select2({
            placeholder: "Search for a contractor code/lastname",
            minimumInputLength: 3,
            ajax: {
                url: "{{ route('ajax-contractors') }}",
                type: 'GET',
                data: function (term) {
                    return {
                        q: term,
                    };
                },
                results: function (response) { 
                    return {
                        results: response.contractors
                    };
                }
            },
            formatResult: contractorFormatResult,
            formatSelection: contractorFormatSelection,
            dropdownCssClass: "bigdrop",
            escapeMarkup: function (m) {
                return m;
            }
        });

        window.addEventListener('load', function() {
        	var contractor = $('#contractor').val();
        	var employee = $('#employee').val();
        	var type = $('#iss_type').val();

        	if(type == 1){
        		$('#select2-chosen-2').html(contractor);
        	}
        	if(type == 0){
        		$('#select2-chosen-1').html(employee);
        	}
        });

        function remove_item(id,name){
        	var totalitem = $('#totalitem').val();

        	if(totalitem == 1){
        		swal({
	                title: '',
	                text: "Please add at least one(1) item and click update button before removing this item.",         
	            });
        	} else {
        		$('#issuanceid').val(id);
	        	$('#itemname').html(name);
	        	$('#remove-item').modal('show');
        	}
        }
	</script>
@endsection
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

	<style>
		@media print {
			#rpt_header { display: none; }
			#rpt_gen_form { display: none; }
			#rpt_toolbar { display: none; }
			#rpt_company { display: block; }
			#rpt_address { display: block; }
		}

		@media screen {
			#rpt_company { display: none; }
			#rpt_address { display: none; }
		}
	</style>
@endsection

@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="row" id="rpt_header">
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
				<a href="#">Reports</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ route('report.issuance-summary') }}">Issuance Request Summary</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<!-- END PAGE HEADER-->

<div class="row">
	<div class="col-md-12">
		<div class="row" id="rpt_gen_form">
			<form>
				<div class="col-md-4">
					<div class="form-group">
						<label>Department</label>
						<select name="department" class="form-control select2me" data-placeholder="Select...">
							<option value="">- Select Department -</option>
							@foreach($departments as $dept)
							<option @if(app('request')->input('department') == $dept->receiver) selected @endif value="{{$dept->receiver}}">{{$dept->receiver}}</option>
							@endforeach
						</select>
						<label>Items</label>
						<select name="item" class="form-control select2me" data-placeholder="Select...">
							<option value="">- Select Item -</option>
							@foreach($items as $item)
							<option @if(app('request')->input('item') == $item->itemDesc) selected @endif value="{{$item->itemDesc}}">{{$item->itemDesc}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<!--/span-->
				<div class="col-md-4">
					<div class="form-group">
						<label>Location</label>
						<select name="location" class="bs-select form-control">
							<option value="">- Select Location -</option>
							<option @if(app('request')->input('location') == 'MILL') selected @endif value="MILL">MILL</option>
							<option @if(app('request')->input('location') == 'MINES') selected @endif value="MINES">MINES</option>
						</select>
						<label style="margin-top: -10px;">End-user type</label>
						<select name="user-type" class="bs-select form-control">
							<option value="">- Select end-user type -</option>
							<option @if(app('request')->input('user-type') == '0') selected @endif value="0">Employee</option>
							<option @if(app('request')->input('user-type') == '1') selected @endif value="1">Contractor</option>
						</select>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Start Date*</label>
						<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
							<input required style="width:250px;" type="text" class="form-control" name="startdate" value="@if(app('request')->input('startdate') != null) {{ app('request')->input('startdate') }} @else {{ \Carbon\Carbon::today()->startOfMonth()->format('Y-m-d') }} @endif" readonly>
							<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
						<label>End Date*</label>
						<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
							<input required style="width:250px;" type="text" class="form-control" name="enddate" value="@if(app('request')->input('enddate') != null) {{ app('request')->input('enddate') }} @else {{ \Carbon\Carbon::today()->endOfMonth()->format('Y-m-d') }} @endif" readonly>
							<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<button style="margin-top: 24px;" type="submit" class="btn purple">Generate</button>
						<a href="{{ route('report.issuance-summary') }}" style="margin-top: 24px;" type="submit" class="btn green">Reset</a>
					</div>
				</div>
			</form>
		</div>

		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet">
			<div class="portlet-body">
				<div class="table-toolbar" id="rpt_toolbar">
					<div class="btn-group pull-right">
						<button class="btn dropdown-toggle" data-toggle="dropdown">Export Options <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="#" onclick="window.print();">Print</a>
							</li>
							<li>
								<a href="#" onclick="export_csv()">Export to Excel </a>
							</li>
						</ul>
					</div>
				</div>
				<br><br>
				<center>
					<h2 id="rpt_company">PHILSAGA MINING CORPORATION</h2>
					<h5 id="rpt_address">Bayugan 3, Rosario, Agusan Del Sur</h5>
					<br>
					<h3>Issuance Request Summary</h3>
					<p>
						@if(app('request')->input('startdate') != null) 
							{{ app('request')->input('startdate') }} @else {{ \Carbon\Carbon::today()->startOfMonth()->format('Y-m-d') }} 
						@endif
						-
						@if(app('request')->input('enddate') != null)
							{{ app('request')->input('enddate') }} @else {{ \Carbon\Carbon::today()->endOfMonth()->format('Y-m-d') }} 
						@endif
					</p>
				</center>
				<br>
				<table class="table table-striped table-bordered table-hover" id="sample_1">
					<thead>
					<tr>
						<th>Control#</th>
						<th>Receiver</th>
						<th>Department</th>
						<th>Location</th>
						<th>Date</th>
						<th>Item</th>
						<th>Color</th>
						<th>Size</th>
						<th>Requested</th>
						<th>Released</th>
					</tr>
					</thead>
					<tbody>
						@forelse($rs as $r)
							<tr>
								<td>{{ $r->controlNum }}</td>
								<td>{{ $r->receiver }}</td>
								<td>{{ $r->dept }}</td>
								<td>{{ $r->location }}</td>
								<td>{{ $r->docDate }}</td>
								<td>{{ $r->itemDesc }}</td>
								<td>{{ $r->itemColor }}</td>
								<td>{{ $r->itemsize }}</td>
								<td>{{ $r->qty }}</td>
								<td>{{ $r->qtyReleased }}</td>
							</tr>
						@empty
							<tr><td colspan="10" class="text-center">No issuance request found.</td></tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<form id="export_form" method="post" action="{{ route('export.issuance_summary') }}" style="display: none;">
	@csrf
	<input type="text" name="startdate" value="@if(app('request')->input('startdate') != null){{ app('request')->input('startdate') }}@else{{ \Carbon\Carbon::today()->startOfMonth()->format('Y-m-d') }}@endif">
	<input type="text" name="enddate" value="@if(app('request')->input('enddate') != null){{ app('request')->input('enddate') }}@else{{ \Carbon\Carbon::today()->endOfMonth()->format('Y-m-d') }}@endif">
	<input type="text" name="department" value="{{app('request')->input('department')}}">
	<input type="text" name="item" value="{{app('request')->input('item')}}">
	<input type="text" name="location" value="{{app('request')->input('location')}}">
	<input type="text" name="user_type" value="{{app('request')->input('user-type')}}">
</form>
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
		function export_csv(){
			$('#export_form').submit();
		}
	</script>
@endsection
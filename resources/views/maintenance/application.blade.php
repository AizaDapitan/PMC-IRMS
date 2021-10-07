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
				<a href="{{ route('maintenance.application.index') }}">Application</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->

	<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title" id="titleLabel" name="titleLabel"></h4>
		</div>

		<form id="form" role="form" action="{{ route('maintenance.application.store') }}" method="POST">
			@csrf

            <input type="hidden" name="_method" id="method" value="POST">
            <input type="hidden" name="id" id="id" value=""> 

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">

                        <div class="form-group">
                                <label class="control-label">Date</label><i class="font-red"> *</i>
                                <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                    <input required type="date" name="scheduled_date" id="scheduled_date" class="form-control">
                                </div>                                             
                        </div>              

                        <div class="form-group">
                            <label class="control-label">Time</label><i class="font-red"> *</i>
                            <input required type="time" name="scheduled_time" class="form-control" id="scheduled_time">
                        </div>

                        <div class="form-group last">
                            <label class="control-label">Reason</label><i class="font-red"> *</i>
                            <textarea required type="text" placeholder="Reason" name="reason" id="reason" class="form-control"></textarea>
                        </div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                <input type="submit" class="btn green" value="Save">
			</div>
			
		</form>
	</div>


<div class="main">
    <div class="container">
        <div class="col-md-12 tab-style-1">

            <div class="breadcrumbs">                

                <h1>Scheduled Shutdown List</h1>
                
            </div>
            @if(session('down'))
                <div id="errdiv" class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <span class="fa fa-exclamation"></span>                
                    {!! session('down') !!}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <span class="fa fa-check-square-o"></span>
                    {!! session('success') !!}
                </div>
            @endif

        <form method="POST" action="{{ route('maintenance.application.search') }}" class="mb-5">
                @csrf
                @if($create)
                    <a class="btn green" data-toggle="modal" href="#basic" onclick="addSchedule()"> Create a Scheduled Shutdown </a>
                @else
                    <button class="btn green" disabled> Create a Scheduled Shutdown </button>
                @endif
               
            </form>

            <div class="table-toolbar">
              <div class="row">
                  <div class="col-md-12" style="direction:rtl;">
                      <div class="btn-group">
                          <a onclick="return confirm('Are you sure you want to run reindexing?')" href="{{ route('maintenance.application.create_indexing') }}" class="btn sbold green"> Reindex Application Database</a>                                                    
                      </div>
                      <div class="btn-group">
                          <a onclick="return confirm('Are you sure you want to start application?')" href="{{ route('maintenance.application.systemUp') }}" class="btn sbold blue"> Start</a>                                                    
                      </div>
                      <div class="btn-group">
                          <a onclick="return confirm('Are you sure you want to stop application?')" href="{{ route('maintenance.application.systemDown') }}" class="btn sbold red"> Stop</a>                                                    
                      </div>
                  </div>
              </div>
          </div>    
            
            </br>
            <table class="table table-striped table-hover" id="sample_1">
                <thead>
                    <tr>
                        <th>Scheduled Date</th>
                        <th>Scheduled Time</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                    <tr>                              
                        <td>{{$application['scheduled_date']}}</td>
                        <td>{{$application['scheduled_time']}}</td>
                        <td>{{$application['reason']}}</td>
                        <td class="text-center">
                            @if($edit)
                                <a onclick="getApplicationDetails({!! $application['id'] !!})" data-toggle="modal" data-target="#basic"  class="btn btn-sm blue btn-outline filter-submit margin-bottom"><i class="fa fa-edit"></i> Edit</a>
                                <a data-toggle="modal"  class="btn btn-sm red btn-outline filter-submit margin-bottom" href="#remove{{ $application['id' ]}}"><span class="fa fa-trash-o"></span> Remove</a>
                            @else
                                <button disabled class="btn btn-sm blue btn-outline filter-submit margin-bottom"><i class="fa fa-edit"></i> Edit</button>
                                <button disabled class="btn btn-sm red btn-outline filter-submit margin-bottom"><span class="fa fa-trash-o"></span> Remove</button>
                            @endif
                            
                        </td>               

                    </tr>
                    @endforeach

                <tbody>
            </table>

        </div>
    </div>
</div>

@foreach($applications as $application)
<div class="modal fade" id="remove{{ $application['id'] }}" tabindex="-1" role="basic" aria-hidden="true">

    <div class="modal-body">
        <form action="{{ route('maintenance.application.destroy', $application['id']) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Confirmation</b></h4>
            </div>
            <div class="modal-body"> Are you sure you want to <b>Remove</b> this schedule? </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" name="remove" class="btn btn-circle red"><span class="fa fa-trash"></span> Remove</button>
            </div>
            
        </form>
    </div>
</div>
@endforeach
@endsection

@section('pagejs')
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>

@endsection

@section('customjs')
	<script type="text/javascript">

		$(document).ready(function(){                
                    
                });
          
                function addSchedule() {
                                  
                  $("#titleLabel").text(" Create a Scheduled Shutdown");                        
                  $('#id').val('');
                  $('#scheduled_date').val('');
                  $('#scheduled_time').val('');
                  $('#reason').val('');
          
                  $('#method').val('POST');
                  $('#form').attr('action', '{{ route('maintenance.application.store') }}');
              }
          
                  function getApplicationDetails(id) {
                      $.ajax({
                          url: '{!! route('maintenance.application.edit') !!}',
                          type: 'POST',
                          async: false,
                          dataType: 'json',
                          data:{
                              _token: '{!! csrf_token() !!}',
                              id: id
                          },
                          success: function(response){
                              $('#cancel').show();
          
                              $("#titleLabel").text(" Update a Scheduled Shutdown");
                      
                              $('#scheduled_date').val(response.scheduled_date);
                              $('#scheduled_time').val(response.scheduled_time.replace(':00.0000000',''));                
                              $('#reason').val(response.reason);
                                              
                              $('#id').val(id);                
                              $('#method').val('PUT');
                              $('#form').attr('action', '{{ route('maintenance.application.update') }}');
                              $('#submit').html('<span class="glyphicon glyphicon-edit"></span> Update');
                          }
                      });
                  }
          
                  function systemDown(id) {
                  $.ajax({
                      url: '{!! route('maintenance.application.systemDown') !!}',
                      type: 'POST',
                      async: false,
                      success: function(response) {
                         
                      }
                  });
              }

	</script>
@endsection
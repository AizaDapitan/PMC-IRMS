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
				<a href="#">Create User</a>
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
					<form autocomplete="off" action="{{ route('users.store') }}" method="post">
						@csrf
						<div class="form-body">
							<div class="form-group">
								<label class="control-label">Employee</label>
								<input required name="test" type="hidden" id="select2_employee" class="form-control select2">
								<input type="hidden" name="employee" id="employee" class="@error('employee') is-invalid @enderror">
								@error('employee')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="control-label">Username</label>
								<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username') }}" placeholder="Username">
								@error('username')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="control-label">Password</label>
								<input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" id="password" placeholder="********">
								<small class=><b>Minimum of eight (8) alphanumeric characters (combination of letters and numbers) with at least one (1) upper case and one (1) special character.</b></small><br>
								@error('password')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="control-label">Confirm Password</label>
								<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="********">
								@error('password_confirmation')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="control-label">Location*</label>
								<select name="location" class="bs-select form-control">
									<option value="MILL">Mill</option>
									<option value="MINES">Mines</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Role*</label>
								<select class="bs-select form-control" name="role">
									<option value="user">User</option>
									<option value="approver">Approver</option>
								</select>
							</div>
						</div>
						<div class="form-actions right">
							<button type="submit" class="btn green">Save</button>
							<button type="button" class="btn default">Cancel</button>
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

@section('customjs')
	<script>
		function employeeFormatResult(employee) {
			
            var result = "<table class='movie-result'><tr>";

            result += "<td valign='top'>"+employee.LName+", "+employee.FName+" "+employee.MName+"</td>";

            result += "</tr></table>"
            return result;
        }

        function employeeFormatSelection(employee) {
        	$('#employee').val(employee.LName+", "+employee.FName+" "+employee.MName);
            return employee.LName+", "+employee.FName+" "+employee.MName;
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
                        results: response.employees
                    };
                }
            },
            formatResult: employeeFormatResult,
            formatSelection: employeeFormatSelection,
            dropdownCssClass: "bigdrop",
            escapeMarkup: function (m) {
                return m;
            }
        });
	</script>
@endsection


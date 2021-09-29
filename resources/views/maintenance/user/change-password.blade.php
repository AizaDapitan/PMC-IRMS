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
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
	<div class="row">
		<div class="col-md-4">
			<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Change Password Form
							</div>
						</div>
						<div class="portlet-body form">
							<form role="form" method="post" action="{{ route('update-password') }}">
								@method('put')
								@csrf
								<div class="form-body">
									<div class="form-group">
										<label>Current Password*</label>
										<input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="********">
										@error('current_password')
		                                    <span class="invalid-feedback text-danger" role="alert">
		                                        <strong>{{ $message }}</strong>
		                                    </span>
		                                @enderror
									</div>
									<div class="form-group">
										<label>New Password*</label>
										<input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="********">
										<small class=><b>Minimum of eight (8) alphanumeric characters (combination of letters and numbers) with at least one (1) upper case and one (1) special character.</b></small><br>
										@error('new_password')
		                                    <span class="invalid-feedback text-danger" role="alert">
		                                        <strong>{{ $message }}</strong>
		                                    </span>
		                                @enderror
									</div>
									<div class="form-group">
										<label>Confirm Password*</label>
										<input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="********">
										@error('confirm_password')
		                                    <span class="invalid-feedback text-danger" role="alert">
		                                        <strong>{{ $message }}</strong>
		                                    </span>
		                                @enderror
									</div>
								</div>
								<div class="form-actions right">
									<a href="{{ route('issuances.index') }}" class="btn default">Cancel</a>
									<button type="submit" class="btn green">Submit</button>
								</div>
							</form>
						</div>
					</div>
		</div>
	</div>
<!-- END PAGE CONTENT-->
@endsection
@extends('layouts.apps')

@section('pagecss')
	<link href="{{ asset('assets/admin/pages/css/error.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 page-500">
		<div class=" number">
			 500
		</div>
		<div class=" details">
			<h3>Oops! Couldn't connect to servers.</h3>
			<p>
				Please contact ICT for .<br/>
				Please come back in a while. <br/>
				<a href="{{ route('issuances.index')}}">Return to Issuances </a>.<br/>
			</p>
		</div>
	</div>
</div>
@endsection
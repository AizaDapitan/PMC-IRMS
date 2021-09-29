@extends('layouts.apps')

@section('content')
<div class="invoice">
	<div class="row invoice-logo">
		<div class="col-xs-12">
			<center>
				<h3>PHILSAGA MINING CORPORATION</h3>
				<h5>Bayugan 3, Rosario, Agusan Del Sur</h5>
				<br><br><br>
				<h4>PPE ISSUANCE REQUEST</h4>
			</center>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-xs-3">
			<ul class="list-unstyled">
				<li>
					<b>TO</b>
				</li>
				<li>
					<b>FROM</b>
				</li>
				<li>
					<b>DATE</b>
				</li>
				<li>
					<b>SUBJECT</b>
				</li>
				<li>
					<b>GL ACCOUNT</b>
				</li>
				<li>
					<b>CONTROL #</b>
				</li>
				<li>
					<b>RECEIVED BY</b>
				</li>
			</ul>
		</div>
		<div class="col-xs-9">
			<ul class="list-unstyled">
				<li>
					:&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;text-decoration: underline;">MCD</span>
				</li>
				<li>
					:&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;text-decoration: underline;">SAFETY AND HEALTH DEPARTMENT</span>
				</li>
				<li>
					:&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;text-decoration: underline;">{{$issuance->docDate}}</span>
				</li>
				<li>
					:&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;text-decoration: underline;">PPE ISSUANCE</span>
				</li>
				<li>
					:&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;text-decoration: underline;">{{$glCode->glAccount}}</span>
				</li>
				<li>
					:&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;text-decoration: underline;">{{$issuance->controlNum}}</span>
				</li>
				<li>
					:&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;text-decoration: underline;">{{$issuance->receiver}}</span>
				</li>
			</ul>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-striped table-hover">
				<thead>
				<tr style="color:blue;">
					<th width="5%">#</th>
					<th width="25%">Item</th>
					<th width="10%">Size</th>
					<th width="10%">Color</th>
					<th width="20%">Last Issue</th>
					<th width="20%">Remarks</th>
					<th width="5%">Qty</th>
					<th width="5%">Status</th>
				</tr>
				</thead>
				<tbody>
				@foreach($issuance->items as $item)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $item->itemDesc }}</td>
						<td>{{ $item->itemSize }}</td>
						<td>{{ $item->itemColor }}</td>
						<td>{{ date('m-d-Y',strtotime($item->lastIssueDate)) }}</td>
						<td>{{ $item->remarks }}</td>
						<td>{{ $item->qty }}</td>
						<td>{{ $item->qtyReleased }}/{{ $item->qty }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-xs-4">
			<ul class="list-unstyled amounts">
				<li>
					<strong>Prepared By:</strong>
				</li>
				<li>
					<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="text-decoration: underline;">{{ auth()->user()->name }}</b>
				</li>
			</ul>
		</div>
		<div class="col-xs-8 invoice-block">
			<ul class="list-unstyled amounts">
				<li>
					<strong>Noted By:</strong>
				</li>
				<li>
					<br>______________________________
				</li>
			</ul>
		</div>
	</div>
</div>
@endsection

@section('pagejs')
	<script>
        window.addEventListener('load', function() {
            window.print();
        })
    </script>
@endsection

<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 3.1.2
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8"/>
	<title>PMC | PPE IRMS</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="{{ asset('assets/google-font.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>

	<link href="{{ asset('assets/admin/layout/css/themes/darkblue.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.css') }}"/>
	<!-- END PAGE LEVEL STYLES -->

	<!-- BEGIN THEME STYLES -->
	<link href="{{ asset('assets/global/css/components.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
	<!-- Styles -->
	<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

	@yield('pagecss')

	<style>
		.btn-search { margin-top: -3px; }
		.btn-reset  { margin-top: -3px; }
		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f6f6f6;
			min-width: 230px;
			overflow: auto;
			border: 1px solid #ddd;
			z-index: 1;
		}
		.dropdown-content a {
			color: black;
			padding: 6px 0 6px 13px;
			text-decoration: none;
			display: block;
		}

		.dropdown a:hover {background-color: #ddd;}
	</style>

	<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
	<!-- BEGIN HEADER -->
	<div class="page-header navbar navbar-fixed-top">
		<!-- BEGIN HEADER INNER -->
		@include('layouts.header-menu')
		<!-- END HEADER INNER -->
	</div>
	<!-- END HEADER -->

	<div class="clearfix"></div>

	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- <div class="theme-panel hidden-xs hidden-sm">
					<div class="toggler">
					</div>
					<div class="toggler-close">
					</div>
					<div class="theme-options">
						<div class="theme-option theme-colors clearfix">
							<span>
							THEME COLOR </span>
							<ul>
								<li class="color-default current tooltips" data-style="default" data-original-title="Default">
								</li>
								<li class="color-darkblue tooltips" data-style="darkblue" data-original-title="Dark Blue">
								</li>
								<li class="color-blue tooltips" data-style="blue" data-original-title="Blue">
								</li>
								<li class="color-grey tooltips" data-style="grey" data-original-title="Grey">
								</li>
								<li class="color-light tooltips" data-style="light" data-original-title="Light">
								</li>
								<li class="color-light2 tooltips" data-style="light2" data-html="true" data-original-title="Light 2">
								</li>
							</ul>
						</div>
						<div class="theme-option">
							<span>
							Layout </span>
							<select class="layout-option form-control input-small">
								<option value="fluid" selected="selected">Fluid</option>
								<option value="boxed">Boxed</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Header </span>
							<select class="page-header-option form-control input-small">
								<option value="fixed" selected="selected">Fixed</option>
								<option value="default">Default</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Sidebar </span>
							<select class="sidebar-option form-control input-small">
								<option value="fixed">Fixed</option>
								<option value="default" selected="selected">Default</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Sidebar Position </span>
							<select class="sidebar-pos-option form-control input-small">
								<option value="left" selected="selected">Left</option>
								<option value="right">Right</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Footer </span>
							<select class="page-footer-option form-control input-small">
								<option value="fixed">Fixed</option>
								<option value="default" selected="selected">Default</option>
							</select>
						</div>
					</div>
				</div> -->
				<div id="myModal1" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content" id="content">
                            <span class="close" id="close">&times;</span>
                            <p style="font-size: 18px; font-weight:bold;">In exactly 1 hour the system will undergo maitenance! Please save your work!</p>
                        </div>
                    </div>
                    <div>
                        @if($reason)
                        <div class="alert alert-danger alert-dismissable">
                            <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> -->
                            <span class="fa fa-exclamation"></span>
                            <label aria-labelledby="notifications" id="notifications">{{ $reason }} </label>
                            <label aria-labelledby="countdown" id="countdown" style="float:right; font-weight:bold">Time Remaining : </label>
                            <label aria-labelledby="datetime" id="datetime" style="display:block">Shutdown Date : {{ $scheduledate }} {{ $scheduletime}} </label>
                        </div>
                        @else
                        <label aria-labelledby="countdown" id="countdown" style="display:none; font-weight:bold">Time Remaining : </label>
                        @endif
                    </div>
				@yield('content')
				
			</div>
		</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->

	<!-- BEGIN FOOTER -->
		@include('layouts.footer')
	<!-- END FOOTER -->

	<!-- BEGIN CORE PLUGINS -->
	<script src="{{ asset('assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="{{ asset('assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>

	<script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
	<!-- END PAGE LEVEL SCRIPTS -->
	<script src="{{ url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<!-- <script src="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script> -->
	<!-- END PAGE LEVEL PLUGINS --> 
	<script src="{{ url('assets/global/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>

	@yield('pagejs')

	@yield('customjs')


	@if(Session::has('success'))
        <script>
            var shortCutFunction = 'success';
            var msg = '{!! Session::get('success') !!}';
            var title = 'Success';

            toastr.options = {
                closeButton: $('#closeButton').prop('checked'),
                debug: $('#debugInfo').prop('checked'),
                positionClass: $('#positionGroup input:checked').val() || 'toast-top-right',
                onclick: null
            };

            toastr.options.showDuration = 1000;
            toastr.options.hideDuration = 1000;
            toastr.options.timeOut = 8000;

            toastr.options.showEasing = 'swing';
            toastr.options.hideEasing = 'linear';
            toastr.options.showMethod = 'fadeIn';
            toastr.options.hideMethod = 'fadeOut';

            $("#toastrOptions").text("Command: toastr[" + shortCutFunction + "](\"" + msg + (title ? "\", \"" + title : '') + "\")\n\ntoastr.options = " + JSON.stringify(toastr.options, null, 2));

            var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
            $toastlast = $toast;

            $('#clearlasttoast').click(function () {
                toastr.clear($toastlast);
            });
        </script>
    @endif

    @if(Session::has('duplicate'))
        <script>
            var shortCutFunction = 'warning';
            var msg = '{!! Session::get('duplicate') !!}';
            var title = 'Warning';

            toastr.options = {
                closeButton: $('#closeButton').prop('checked'),
                debug: $('#debugInfo').prop('checked'),
                positionClass: $('#positionGroup input:checked').val() || 'toast-top-right',
                onclick: null
            };

            toastr.options.showDuration = 1000;
            toastr.options.hideDuration = 1000;
            toastr.options.timeOut = 8000;

            toastr.options.showEasing = 'swing';
            toastr.options.hideEasing = 'linear';
            toastr.options.showMethod = 'fadeIn';
            toastr.options.hideMethod = 'fadeOut';

            $("#toastrOptions").text("Command: toastr[" + shortCutFunction + "](\"" + msg + (title ? "\", \"" + title : '') + "\")\n\ntoastr.options = " + JSON.stringify(toastr.options, null, 2));

            var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
            $toastlast = $toast;

            $('#clearlasttoast').click(function () {
                toastr.clear($toastlast);
            });
        </script>
    @endif

	<script>

		jQuery(document).ready(function() {    
		   	Metronic.init(); // init metronic core components
		   	Layout.init(); // init current layout
			QuickSidebar.init() // init quick sidebar // initlayout and core plugins
		});
	var modal = document.getElementById("myModal1");
	var tday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	var tmonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	var shown = 0;
	var span = document.getElementById("close");
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	function GetClock() {
		var d = new Date();
		var nday = d.getDay(),
		nmonth = d.getMonth(),
		ndate = d.getDate(),
		nyear = d.getFullYear();
		var nhour = d.getHours(),
		nmin = d.getMinutes(),
		nsec = d.getSeconds(),
		ap;
		var ohour = nhour + 1;
        if (nhour <= 9) nhour = "0" + nhour;
		if (nhour == 0) {
		ap = " AM";
		nhour = 12;
		} else if (nhour < 12) {
		ap = " AM";
		} else if (nhour == 12) {
		ap = " PM";
		} else if (nhour > 12) {
		ap = " PM";
		nhour -= 12;
		}

		if (nmin <= 9) nmin = "0" + nmin;
		if (nsec <= 9) nsec = "0" + nsec;

		var clocktext = "" + tday[nday] + ", " + tmonth[nmonth] + " " + ndate + ", " + nyear + " " + nhour + ":" + nmin + ":" + nsec + ap + "";
		// document.getElementById('clockbox').innerHTML = clocktext;
		var schedule = {!! json_encode($scheduledate) !!} + ' ' + {!! json_encode($scheduletime) !!};
		// dt = dt.replace(':00.0000000','');
		var mnth = nmonth + 1;
		var dte = ndate;
		if (mnth <= 9) mnth = "0" + mnth;
		if (dte <= 9) dte = "0" + dte;
		var curDateless1hour = nyear + '-' + mnth + '-' + dte + ' ' + ohour + ":" + nmin;
		var curDate = nyear + '-' + mnth + '-' + dte + ' ' + (ohour - 1) + ":" + nmin;
		// console.log(dt);
		// console.log(dd2);
		if (schedule == curDateless1hour && shown == 0) {
		shown = 1;
		//    alert("In exactly 1 hour the system will undergo maitenance! Please save your work.");

		modal.style.display = "block";
		return false;
		}
		if (schedule == curDate) {
		$.ajax({
			url: '{!! route('maintenance.application.systemDown') !!}',
			type: 'GET',
			async: false,
			success: function(response) {}
		});
		}
        // console.log(schedule);
        // console.log(curDate);
		if (schedule > curDate) {
		var TimeDiff = timeDiffCalc(new Date(schedule), new Date());
		} else {
		TimeDiff = "Maintenance is in progress!";
		}

		document.getElementById('countdown').innerHTML = "Time Remaining : " + TimeDiff;
	}
	GetClock();
	setInterval(GetClock, 1000);

	function timeDiffCalc(dateFuture, dateNow) {
		// console.log(dateNow);
		let diffInMilliSeconds = Math.abs(dateFuture - dateNow) / 1000;
		// calculate days
		const days = Math.floor(diffInMilliSeconds / 86400);
		diffInMilliSeconds -= days * 86400;

		// calculate hours
		const hours = Math.floor(diffInMilliSeconds / 3600) % 24;
		diffInMilliSeconds -= hours * 3600;

		// calculate minutes
		const minutes = Math.floor(diffInMilliSeconds / 60) % 60;
		diffInMilliSeconds -= minutes * 60;

		// calculate minutes
		const seconds = Math.floor(diffInMilliSeconds);
		diffInMilliSeconds -= seconds;
		// if(seconds > 0){

		let difference = '';
		if (days > 0) {
		difference += (days === 1) ? `${days} day, ` : `${days} days, `;
		}

		difference += (hours === 0 || hours === 1) ? `${hours} hour, ` : `${hours} hours, `;

		difference += (minutes === 0 || hours === 1) ? `${minutes} minute, ` : `${minutes} minutes, `;

		difference += (seconds === 0 || seconds === 1) ? `${seconds} seconds` : `${seconds} seconds`;

		return difference;
		// }
	}
	</script>
</body>
</html>
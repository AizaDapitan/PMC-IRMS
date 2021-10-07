<div class="page-header-inner">
	<!-- BEGIN LOGO -->
	<div class="page-logo" style="margin-top: 5px;">
		<a href="{{ route('issuances.index') }}" >
		<h4 style="color:white;">PPE Issuance Monitoring</h4> 
		</a>
	</div>
	<!-- END LOGO -->

	<!-- BEGIN HORIZANTAL MENU -->
	<div class="hor-menu hidden-sm hidden-xs">
		<ul class="nav navbar-nav">
			<li class="@if (\Route::current()->getName() == 'issuances.index' || \Route::current()->getName() == 'issuances.edit') active @endif">
				<a href="{{ route('issuances.index') }}">Issuances <span class="selected"></span></a>
			</li>
			<li class="@if (\Route::current()->getName() == 'issuances.create') active @endif">
				<a href="{{ route('issuances.create') }}">Add New Issuance </a>
			</li>
			<li class="classic-menu-dropdown @if (\Route::current()->getName() == 'ppe-items.index' || \Route::current()->getName() == 'ppe-types.index' || \Route::current()->getName() == 'users.index') active @endif">
				<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">Maintenance <i class="fa fa-angle-down"></i></a>
				<ul class="dropdown-menu pull-left">
					<li>
						<a href="{{ route('ppe-items.index') }}"><i class="fa fa-user"></i> PPE Items </a>
					</li>
					<li>
						<a href="{{ route('ppe-types.index') }}"><i class="fa fa-bookmark-o"></i> PPE Type </a>
					</li>

					<li>
						<a href="{{ route('roles.index') }}"><i class="fa fa-bookmark-o"></i> Roles </a>
					</li>

					<li>
						<a href="{{ route('permissions.index') }}"><i class="fa fa-bookmark-o"></i> Permissions </a>
					</li>
					
					<li>
						<a href="{{ route('users.index') }}"><i class="fa fa-users"></i> Users </a>
					</li>

					<li>
						<a href="{{ route('maintenance.roleaccessrights') }}"><i class="fa fa-bookmark-o"></i> Role Access Rights </a>
					</li>

					<li>
						<a href="{{ route('maintenance.useraccessrights') }}"><i class="fa fa-bookmark-o"></i> User Access Rights </a>
					</li>	

					<li>
						<a href="{{ route('maintenance.application.index') }}"><i class="fa fa-bookmark-o"></i> Application </a>
					</li>									

				</ul>
			</li>
			<li class="classic-menu-dropdown @if (\Route::current()->getName() == 'report.issuance-summary' || \Route::current()->getName() == 'report.cancelled-issuances' || \Route::current()->getName() == 'report.unserve-issuances') active @endif">
				<a data-hover="dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">Reports <i class="fa fa-angle-down"></i></a>
				<ul class="dropdown-menu pull-left">
					<li>
						<a href="{{ route('report.issuance-summary') }}"><i class="fa fa-bookmark-o"></i> Issuance Request Summary </a>
					</li>
					<li>
						<a href="{{ route('report.cancelled-issuances') }}"><i class="fa fa-user"></i> Cancelled Issuance Request </a>
					</li>
					<li>
						<a href="{{ route('report.unserve-issuances') }}"><i class="fa fa-user"></i> Unserved Issuance Request </a>
					</li>
					<li>
						<a href="{{ route('report.audit-logs') }}"><i class="fa fa-user"></i> Audit Logs </a>
					</li>
					<li>
						<a href="{{ route('report.error-logs') }}"><i class="fa fa-user"></i> Error Logs </a>
					</li>
				</ul>
			</li>
			<li>
				<a href="">
				IRMS Manual </a>
			</li>
		</ul>
	</div>
	<!-- END HORIZANTAL MENU -->

	<!-- BEGIN HEADER SEARCH BOX -->
	<!-- <form class="search-form" action="extra_search.html" method="GET">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search..." name="query">
			<span class="input-group-btn">
			<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
			</span>
		</div>
	</form> -->
	<!-- END HEADER SEARCH BOX -->

	<!-- BEGIN RESPONSIVE MENU TOGGLER -->
	<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
	</a>
	<!-- END RESPONSIVE MENU TOGGLER -->

	<!-- BEGIN TOP NAVIGATION MENU -->
	<div class="top-menu">
		<ul class="nav navbar-nav pull-right">

			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown dropdown-user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<img alt="" class="img-circle" src="{{ asset('images/user.png') }}"/>
				<span class="username">{{ auth()->user()->username }}</span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="{{ route('change-password') }}"><i class="fa fa-user"></i> Change Password</a></li>
					<li>
						<a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> Log Out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
	</div>
	<!-- END TOP NAVIGATION MENU -->
</div>
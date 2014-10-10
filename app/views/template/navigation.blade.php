<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">{{ _('ENUM ID') }}</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li @if(Request::segment(1)=='') class="active" @endif><a href="/">{{ _('Home') }}</a></li>

				@if (Auth::check())
				<li @if(Request::segment(1)=='dashboard') class="active" @endif>{{ link_to('dashboard', _('Dashboard')) }}</li>
				@if (Auth::user()->status == 2)
				<li class="dropdown" @if(Request::segment(1)=='users') class="active" @endif>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('Settings')}} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>{{ link_to('users', _('Manage User')) }}</li>
					</ul>
				</li>
				@endif
				<li>
				<li class="dropdown @if(Request::segment(1)=='profile' || Request::segment(1)=='user') active @endif">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('My account')}} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>{{ link_to('profile', _('Profile')) }}</li>
						<li>{{ link_to('user', _('User')) }}</li>
					</ul>
				</li>
				<li>{{ link_to('logout', _('Logout')) }}</li>
				@else
				<li @if(Request::segment(1)=='login') class="active" @endif>{{ link_to('login', _('Login')) }}</li>
				<li @if(Request::segment(1)=='register') class="active" @endif>{{ link_to('register', _('Register')) }}</li>
				<li @if(Request::segment(1)=='password') class="active" @endif>{{ link_to('password/recovery', _('Password recovery')) }}</li>
				@endif
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>

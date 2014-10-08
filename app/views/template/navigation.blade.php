<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">{{ _('Project name') }}</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="/">{{ _('Home') }}</a></li>

				@if (Auth::check())
				<li>{{ link_to('dashboard', _('Dashboard')) }}</li>
				@if (Auth::user()->status == 2)
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('Settings')}} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>{{ link_to('users', _('Manage User')) }}</li>
					</ul>
				</li>
				@endif
				<li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('My account')}} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>{{ link_to('profile', _('Profile')) }}</li>
						<li>{{ link_to('user', _('User')) }}</li>
					</ul>
				</li>
				<li>{{ link_to('logout', _('Logout')) }}</li>
				@else
				<li>{{ link_to('login', _('Login')) }}</li>
				<li>{{ link_to('register', _('Register')) }}</li>
				<li>{{ link_to('password/recovery', _('Password recovery')) }}</li>
				@endif
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>

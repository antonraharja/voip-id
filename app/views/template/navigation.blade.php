<div class="container">
	<nav class='navbar navbar-inverse' role='navigation'>
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
			</button>
			<a class="navbar-brand" href="#">{{ _('Brand') }}</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a href="/">{{ _('Home') }}</a></li>

				@if (Auth::check())
				<li>{{ link_to('dashboard', _('Dashboard')) }}</li>
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
		</div><!-- /.navbar-collapse -->
	</nav>
</div>

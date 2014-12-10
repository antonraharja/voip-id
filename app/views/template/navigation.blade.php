<div class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			@if(Cookie::get('domain_hash'))
			<a class="navbar-brand" href="#">{{ (Domain::find(Cookie::get('domain_hash'))->title) ? Domain::find(Cookie::get('domain_hash'))->title : _('Telepon Rakyat') }}</a>
			@else
			<a class="navbar-brand" href="#">{{ _('Telepon Rakyat') }}</a>
			@endif
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li @if(Request::segment(1)=='') class="active" @endif><a href="/">{{ _('Home') }}</a></li>

				@if (Auth::check())
				<li @if(Request::segment(1)=='dashboard') class="active" @endif>{{ link_to('dashboard', _('Dashboard')) }}</li>
				@if (Auth::user()->status == 3)
				    <li class="dropdown @if(Request::segment(1)=='domain') active @endif">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('Settings')}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>{{ link_to('domain', _('Manage Domain')) }}</li>
                        </ul>
                    </li>
				@endif
				@if (Auth::user()->status == 4)
				    <li class="dropdown @if(Request::segment(1)=='phone_number') active @endif">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('Settings')}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>{{ link_to('phone_number', _('Phone Number')) }}</li>
                        </ul>
                    </li>
				@endif
				@if (Auth::user()->status == 2)
				<li class="dropdown @if(Request::segment(1)=='users' || Request::segment(1)=='managers' || Request::segment(1)=='domain' || Request::segment(1)=='main_config') active @endif">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('Settings')}} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>{{ link_to('managers', _('Manage Managers')) }}</li>
						<li>{{ link_to('users', _('Manage Users')) }}</li>
						<li>{{ link_to('domain', _('Manage Domains')) }}</li>
						<li>{{ link_to('main_config', _('Main Configuration')) }}</li>
					</ul>
				</li>
				@endif
				<li>
				<li class="dropdown @if(Request::segment(1)=='profile' || Request::segment(1)=='user') active @endif">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('My account')}} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>{{ link_to('profile', _('Profile')) }}</li>
						<li>{{ link_to('user', _('Account')) }}</li>
						<li class="divider"></li>
				        <li>{{ link_to('logout', _('Logout')) }}</li>
					</ul>
				</li>
				@else
				<li @if(Request::segment(1)=='login') class="active" @endif>{{ link_to('login', _('Login')) }}</li>
				<li @if(Request::segment(1)=='register') class="active" @endif>{{ link_to('register', _('Register')) }}</li>
				@endif
				<li @if(Request::segment(1)=='contact') class="active" @endif>{{ link_to('contact', _('Contact us')) }}</li>
			</ul>
			@if(Cookie::get('domain_hash'))
            <ul class="nav navbar-nav navbar-right">
                <li><a class="navbar-brand" href="#">{{ Domain::find(Cookie::get('domain_hash'))->domain }}</a></li>
            </ul>
            @endif
		</div><!--/.nav-collapse -->
	</div>
</div>

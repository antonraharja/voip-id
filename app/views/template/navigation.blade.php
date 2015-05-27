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
                <a class="navbar-brand"
                   href="#">{{ (Domain::find(Cookie::get('domain_hash'))->title) ? Domain::find(Cookie::get('domain_hash'))->title : _('VoIP ID') }}</a>
            @else
            	<a class="navbar-brand"
                   href="#"><img src="{{ asset('img/logo.png') }}" align="middle" border="no" height="20"></a> 
            @endif
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li @if(Request::segment(1)=='') class="active" @endif><a href="/">{{ _('Home') }}</a></li>

                @if (Auth::check())
                    <li @if(Request::segment(1)=='dashboard')
                        class="active" @endif>{{ link_to('dashboard', _('Dashboard')) }}</li>

                    <li class="dropdown @if(Request::segment(1)=='domain') active @endif">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('Settings')}} <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->status == 2)
                                <li>{{ link_to('managers', _('Manage Managers')) }}</li>
                                <li>{{ link_to('users', _('Manage Users')) }}</li>
                                <li>{{ link_to('main_config', _('Main Configuration')) }}</li>
                            @endif
                            @if (Auth::user()->status == 3 || Auth::user()->status == 2)
                                <li>{{ link_to('domain', _('Manage Domain')) }}</li>
                                <li>{{ link_to('gateway', _('Manage Gateway')) }}</li>
                            @endif
                            @if (Auth::user()->status == 4)
                                <li>{{ link_to('phone_number', _('Phone Number')) }}</li>
                            @endif
                        </ul>
                    </li>
                    <li class="dropdown @if(Request::segment(1)=='online_phones') active @endif">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('Reports')}} <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->status == 4 || Auth::user()->status == 3 || Auth::user()->status == 2)
                                <li>{{ link_to('call_detail_reports', _('Call Detail Records')) }}</li>
                            @endif
                            <li>{{ link_to('online_phones', _('Online Phones')) }}</li>
                            
                        </ul>
                    </li>
                    <li class="dropdown @if(Request::segment(1)=='profile' || Request::segment(1)=='user') active @endif">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ _('My account')}} <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                        	 <li>{{ link_to('token', _('Token')) }}</li>
                            <li>{{ link_to('profile', _('Profile')) }}</li>
                            <li>{{ link_to('user', _('Account')) }}</li>
                            <li class="divider"></li>
                            <li>{{ link_to('logout', _('Logout')) }}</li>
                        </ul>
                    </li>
                @else
                    <li @if(Request::segment(1)=='login') class="active" @endif>{{ link_to('login', _('Login')) }}</li>
                    @if(!Cookie::get('domain_hash') || (Cookie::get('domain_hash') && Domain::find(Cookie::get('domain_hash'))->allow_registration == 1))
                        <li @if(Request::segment(1)=='register')
                            class="active" @endif>{{ link_to('register', _('Register')) }}</li>
                    @endif
                @endif
                @if(!Cookie::get('domain_hash'))
                    <li @if(Request::segment(1)=='contact')
                        class="active" @endif>{{ link_to('contact', _('Contact us')) }}</li>
                @endif
            </ul>
            @if(Cookie::get('domain_hash'))
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="navbar-brand" href="#">{{ Domain::find(Cookie::get('domain_hash'))->domain }}</a></li>
                </ul>
            @endif
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

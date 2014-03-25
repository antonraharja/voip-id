<div class="container">
	<nav class='navbar navbar-inverse' role='navigation'>
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
			</button>
			<a class="navbar-brand" href="#">Brand</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a href="/">Home</a></li>

				@if (Auth::check())
				<li><a href="/dashboard">Dashboard</a></li>
				<li><a href="/user/logout">Logout</a></li>
				@else
				<li><a href="/user/login">Login</a></li>
				<li><a href="/user/register">Register</a></li>
				@endif
			</ul>
		</div><!-- /.navbar-collapse -->
	</nav>
</div>
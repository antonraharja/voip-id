<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			@section('title')

			@show
		</title>
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		@if(Cookie::get('domain_hash'))
		{{ HTML::style('css/bootstrap-'.(Domain::find(Cookie::get('domain_hash'))->theme ? Domain::find(Cookie::get('domain_hash'))->theme : 'default').'.min.css') }}
		@else
		{{ HTML::style('css/bootstrap-default.min.css') }}
		@endif
		{{ HTML::style('css/font-awesome.min.css') }}
		{{ HTML::style('css/style.css') }}
	</head>

	<body>
		@include('template.navigation')

		@yield('content')

		@include('template.footer')

		<!-- Scripts -->
		{{ HTML::script('js/jquery.min.js') }}
		{{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::script('js/plugins.js') }}
		{{ HTML::script('js/script.js') }}
	</body>
</html>

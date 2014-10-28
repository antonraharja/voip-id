<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			@section('title')

			@show
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		{{ HTML::style('css/bootstrap.min.css') }}
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

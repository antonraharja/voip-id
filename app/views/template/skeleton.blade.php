<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			@section('title')
			
			@show
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
	</head>

    <body>
		@include('template.navigation')
		
		@yield('content')
		
		@include('template.footer')

		<!-- Scripts -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		{{ HTML::script('js/plugins.js') }}
		{{ HTML::script('js/script.js') }}
	</body>
</html>
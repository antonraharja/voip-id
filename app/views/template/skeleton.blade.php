<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			@section('title')

			@show
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		 <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">
		@if(Cookie::get('domain_hash'))
		{{ HTML::style('css/bootstrap-'.(Domain::find(Cookie::get('domain_hash'))->theme ? Domain::find(Cookie::get('domain_hash'))->theme : 'default').'.min.css') }}
		@else
		{{ HTML::style('css/bootstrap-default.min.css') }}
		@endif
		{{ HTML::style('css/font-awesome.min.css') }}
		{{ HTML::style('css/style.css') }}
		<!--data tables -->
		{{ HTML::style('css/jquery.dataTables.css') }}
		<!-- {{ HTML::style('assets/css/dataTables.bootstrap.css') }} -->
		{{ HTML::script('js/jquery.js') }}
		{{ HTML::script('js/jquery.dataTables.js') }}
		<!-- {{ HTML::script('js/dataTables.bootstrap.js') }} -->
		<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
	$('#enable_pagination').dataTable( {
		"pagingType": "full_numbers",
		"bFilter": false
	} );
} );

	</script>
		
	</head>

	<body>
		@include('template.navigation')

		@yield('content')

		@include('template.footer')

		<!-- Scripts -->
		<!-- {{ HTML::script('js/jquery.min.js') }} -->
		{{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::script('js/plugins.js') }}
		{{ HTML::script('js/script.js') }}
		
		
		
	</body>
</html>

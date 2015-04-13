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
		<!-- {{ HTML::style('css/bootstrap-default.min.css') }} -->
		{{ HTML::style('css/bootstrap.min.css') }}
		@endif
		{{ HTML::style('css/font-awesome.min.css') }}
		{{ HTML::style('css/style.css') }}
		<!--data tables -->
		
		{{ HTML::style('css/dataTables.bootstrap.css') }}
		{{ HTML::style('css/dataTables.responsive.css') }}
		<style type="text/css" class="init">
	body { font-size: 140% }

	table.dataTable th,
	table.dataTable td {
		white-space: nowrap;
	}
	</style>
		
		{{ HTML::script('js/jquery-1.11.1.min.js') }}
		{{ HTML::script('js/jquery.dataTables.min.js') }}
		{{ HTML::script('js/dataTables.responsive.min.js') }}
		{{ HTML::script('js/dataTables.bootstrap.js') }}
		<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
	$('#enable_pagination').DataTable( {
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

@extends('template.skeleton')

@section('title')
@parent
@stop

@section('content')
<div class="container">
	<h1>Login</h1>

	<!-- Success-Messages -->
	@if ($success = Session::get('success'))
	<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		{{{ $success }}}
	</div>
	@endif
	
	<!-- Error-Messages -->
	@if ($error = Session::get('error'))
	<div class="alert alert-danger alert-block">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		{{{ $error }}}
	</div>
	@endif

	{{ Form::open(array('url' => 'user/login', 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('username', 'Username') }}
		{{ Form::text('username') }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Password') }}
		{{ Form::password('password') }}
	</div>

	{{ Form::submit('Login', array('class' => 'btn btn-primary')) }}
	
	{{ Form::close() }}
	
</div>	
@stop

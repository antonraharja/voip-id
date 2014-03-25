@extends('template.skeleton')

@section('title')
@parent
@stop

@section('content')
<div class="container">
	<h1>Register</h1>

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

	{{ Form::open(array('url' => 'user/register', 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('name', 'Name') }}
		{{ Form::text('name', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::email('email', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('username', 'Username') }}
		{{ Form::text('username', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Password') }}
		{{ Form::password('password', array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

</div>
@stop

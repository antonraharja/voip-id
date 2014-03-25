@extends('template.skeleton')

@section('title')
@parent
@stop

@section('content')
<div class="container">
	<h1>Login</h1>

	@include('template.messages')

	{{ Form::open(array('url' => 'user/login', 'method' => 'post')) }}

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

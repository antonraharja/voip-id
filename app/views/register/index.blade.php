@extends('template.skeleton')

@section('title')
{{ _('Register') }}
@stop

@section('content')
<div class="container">
	<h1>{{ _('Register') }}</h1>

	@include('template.messages')

	{{ Form::open(array('url' => 'register', 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('first_name', 'First name') }}
		{{ Form::text('first_name', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('last_name', 'Last name') }}
		{{ Form::text('last_name', '', array('class' => 'form-control')) }}
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

	<div class="form-group">
		{{ Form::label('password_confirmation', 'Confirm password') }}
		{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

</div>
@stop

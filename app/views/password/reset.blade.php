@extends('template.skeleton')

@section('title')
{{ _('Password | Reset') }}
@stop

@section('content')
<div class="container">
	<h1>{{ _('Password reset') }}</h1>

	@include('template.messages')

	{{ Form::open(array('url' => 'password/reset', 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('email', _('Email')) }}
		{{ Form::email('email', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', _('New password')) }}
		{{ Form::password('password', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('password_confirmation', _('New password confirmation')) }}
		{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('token', _('Token')) }}
		{{ Form::text('token', $token, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit(_('Submit'), array('class' => 'btn btn-primary')) }}
	
	{{ Form::close() }}
	
</div>	
@stop

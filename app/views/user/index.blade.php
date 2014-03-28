@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('User') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('User') }}</h1>

		@include('template.messages')

		{{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT')) }}

		<div class="form-group">
			{{ Form::label('email', _('Email')) }}
			{{ Form::text('email', $user->email, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('username', _('Username')) }}
			{{ Form::text('username', $user->username, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('password', _('Password')) }}
			{{ Form::password('password', array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('password_confirmation', _('Password confirmation')) }}
			{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
		</div>

		{{ Form::submit(_('Submit'), array('class' => 'btn btn-primary')) }}
		
		{{ Form::close() }}
	</div>
@stop

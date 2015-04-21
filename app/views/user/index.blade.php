@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Account') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Account') }}</h1>

		@include('template.messages')
		
		<br>

		{{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT')) }}

		<div class="form-group">
			{{ Form::label('email', _('Email')) }}
			{{ Form::text('email', $user->email, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('username', _('Account ID')) }}
			{{ Form::text('username', $user->username, array('class' => 'form-control', 'disabled')) }}
		</div>

		<div class="form-group">
            {{ Form::label('password', 'Password') }}
            <div class="input-group">
                {{ Form::password('password', array('class' => 'form-control')) }}
                <span class="input-group-addon show-password"><span class="glyphicon glyphicon-eye-open"></span></span>
                <span class="input-group-addon tooltips" data-original-title="Fill the password field to change password"><span class="glyphicon glyphicon-info-sign"></span></span>
            </div>
        </div>

		{{ Form::submit(_('Submit'), array('class' => 'btn btn-primary')) }}
		
		{{ Form::close() }}
	</div>
@stop

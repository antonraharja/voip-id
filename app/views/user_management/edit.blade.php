@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('User') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Edit User') }}</h1>

	@include('template.messages')

	{{ Form::open(array('url' => 'users/update/'.$user->id, 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('first_name', 'First Name') }}
		{{ Form::text('first_name', $user->profile->first_name, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('last_name', 'Last name') }}
		{{ Form::text('last_name', $user->profile->last_name, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::email('email', $user->email, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('website', _('Website')) }}
		{{ Form::text('website', $user->profile->website, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('username', 'Username') }}
		{{ Form::text('username', $user->username, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Password') }}
		<div class="input-group">
			{{ Form::password('password', array('class' => 'form-control')) }}
			<span class="input-group-addon show-password"><span class="glyphicon glyphicon-eye-open"></span></span>
			<span class="input-group-addon tooltips" data-original-title="Fill the password field to change password"><span class="glyphicon glyphicon-info-sign"></span></span>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('status', 'Status') }}
		{{ Form::select('status', array('2' => 'Administrator', '3' => 'User'), $user->status, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

</div>
@stop

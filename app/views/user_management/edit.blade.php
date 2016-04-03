@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Account') }}
@stop

@section('content')

<div class="container">
	@if (Request::segment(3))
    	<h1>{{ _('Manage Users') }}</h1>
    	@else
    	<h1>{{ _('Manage Managers') }}</h1>
    	@endif
	<h2>{{ _('Edit Account') }}</h2>

	@include('template.messages')

    @if (Request::segment(4))
	{{ Form::open(array('url' => 'users/update/'.$user->id.'/'.Request::segment(4), 'method' => 'post')) }}
    @elseif(Request::segment(1) == "managers")
    {{ Form::open(array('url' => 'managers/update/'.$user->id, 'method' => 'post')) }}
    @else
	{{ Form::open(array('url' => 'users/update/'.$user->id, 'method' => 'post')) }}
    @endif

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
		{{ Form::label('im_username', 'IM Account') }}
		{{ Form::text('im_username', $user->im_username, array('class' => 'form-control')) }}
	</div>
	
	<div class="form-group">
		{{ Form::label('im_password', 'IM Password') }}
		<div class="input-group">
			{{ Form::password('im_password', array('class' => 'form-control')) }}
			<span class="input-group-addon show-password"><span class="glyphicon glyphicon-eye-open"></span></span>
			<span class="input-group-addon tooltips" data-original-title="Fill the password field to change password"><span class="glyphicon glyphicon-info-sign"></span></span>
		</div>
	</div>
	
	<div class="form-group">
		{{ Form::label('username', 'Account ID') }}
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

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
	<br>
	
	@if (Request::segment(4))
    	<a href="{{ url('domain/users/').'/'.Request::segment(4) }}">
    	@else
    	<a href="{{ url(Request::segment(1)) }}">
    	@endif	
	
	<span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
	</div>
@stop

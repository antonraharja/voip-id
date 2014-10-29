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
	<h2>{{ _('Add Account') }}</h2>

	@include('template.messages')

    @if (Request::segment(3))
	{{ Form::open(array('url' => 'users/save/'.Request::segment(3), 'method' => 'post')) }}
	@else
	{{ Form::open(array('url' => 'users/save', 'method' => 'post')) }}
	@endif

	<div class="form-group">
		{{ Form::label('first_name', 'First Name') }}
		{{ Form::text('first_name', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('last_name', 'Last Name') }}
		{{ Form::text('last_name', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::email('email', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('website', _('Website')) }}
		{{ Form::text('website', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('username', 'Account ID') }}
		{{ Form::text('username', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Password') }}
		<div class="input-group">
			{{ Form::password('password', array('class' => 'form-control')) }}
			<span class="input-group-addon show-password"><span class="glyphicon glyphicon-eye-open"></span></span>
		</div>
	</div>

    @if (Request::segment(3))
		{{ Form::hidden('status',4) }}
    @else
    <div class="form-group">
        {{ Form::label('status', 'Status') }}
        {{ Form::select('status', array('2' => 'Administrator', '3' => 'Manager'), '3', array('class' => 'form-control')) }}
    </div>
    @endif

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

</div>
@stop

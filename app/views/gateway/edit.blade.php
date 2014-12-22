@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Manage Domain') }}</h1>
	<h2>{{ _('Edit Domain') }}</h2>

	@include('template.messages')

	{{ Form::open(array('url' => 'gateway/update/'.$gateway->id, 'method' => 'post')) }}

	@if(Auth::user()->status == 2)
		<div class="form-group">
			{{ Form::label('user_id', _('Owner')) }}
			{{ Form::select('user_id', $users, $gateway->user_id, array('class' => 'form-control')) }}
		</div>
	@endif

	<div class="form-group">
		{{ Form::label('gateway_name', _('Gateway name')) }}
		{{ Form::text('gateway_name', $gateway->gateway_name, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('gateway_address', _('Gateway address')) }}
		{{ Form::text('gateway_address', $gateway->gateway_address, array('class' => 'form-control', 'readonly')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
    <br>
    <a href="{{ url('gateway') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
</div>
@stop

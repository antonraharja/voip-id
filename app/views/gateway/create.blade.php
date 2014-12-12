@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Gateway') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Manage Gateway') }}</h1>
	<h2>{{ _('Add Gateway') }}</h2>

	@include('template.messages')

	{{ Form::open(array('url' => 'gateway/store', 'method' => 'post')) }}

    <div class="form-group">
        {{ Form::label('gateway_name', _('Gateway name')) }}
        {{ Form::text('gateway_name', '', array('class' => 'form-control')) }}
    </div>

	<div class="form-group">
		{{ Form::label('gateway_address', _('Gateway address')) }}
		{{ Form::text('gateway_address', '', array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
    <br>
    <a href="{{ url('gateway') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
</div>
@stop

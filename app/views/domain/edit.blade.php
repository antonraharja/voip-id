@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Manage Domain') }}</h1>
	<h2>{{ _('Edit Domain') }}</h2>

	@include('template.messages')

	{{ Form::open(array('url' => 'domain/update/'.$domain->id, 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('domain', _('Domain name for Control Panel (DCP)')) }}
		{{ Form::text('domain', $domain->domain, array('class' => 'form-control', 'readonly')) }}
	</div>

	<div class="form-group">
		{{ Form::label('sip_server', _('Domain name for SIP Server (DSS)')) }}
		{{ Form::text('sip_server', $domain->sip_server, array('class' => 'form-control', 'readonly')) }}
	</div>

	<div class="form-group">
		{{ Form::label('description', _('Description')) }}
		{{ Form::text('description', $domain->description, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
    <br>
    <a href="{{ url('domain') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
</div>
@stop

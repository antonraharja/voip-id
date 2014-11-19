@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Phone Number') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Manage Phone Number') }}</h1>
	<h2>{{ _('Add Phone Number') }}</h2>

	@include('template.messages')

	{{ Form::open(array('url' => 'phone_number/store', 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('phone_number', 'Phone Number') }}
		{{ Form::text('phone_number', $data['global_prefix'].' '.$data['domain']->prefix.' '.$data['extension'], array('class' => 'form-control','readonly'=>true)) }}
	</div>

	<div class="form-group">
        {{ Form::label('sip_username', 'SIP Username') }}
        {{ Form::text('sip_username', $data['extension'], array('class' => 'form-control','readonly'=>true)) }}
    </div>

    <div class="form-group">
        {{ Form::label('sip_domain', 'SIP Domain') }}
        {{ Form::text('sip_domain', $data['domain']->domain, array('class' => 'form-control','readonly'=>true)) }}
    </div>

    <div class="form-group">
        {{ Form::label('sip_server', 'SIP Server') }}
        {{ Form::text('sip_server', $data['domain']->sip_server, array('class' => 'form-control','readonly'=>true)) }}
    </div>

    <div class="form-group">
        {{ Form::label('sip_password', 'SIP Password') }}
        <div class="input-group">
            {{ Form::password('sip_password', array('class' => 'form-control')) }}
            <span class="input-group-addon show-password"><span class="glyphicon glyphicon-eye-open"></span></span>
            <span class="input-group-addon tooltips" data-original-title="Required. Six alphanumeric only"><span class="glyphicon glyphicon-info-sign"></span></span>
        </div>
    </div>

	<div class="form-group">
		{{ Form::label('description', 'Description') }}
		{{ Form::text('description', '', array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
    <br>
    <a href="{{ url('phone_number') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
</div>
@stop

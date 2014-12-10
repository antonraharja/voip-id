@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Phone Number') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Manage Phone Number') }}</h1>
	<h2>{{ _('Edit Phone Number') }}</h2>

	@include('template.messages')

	@if(Request::segment(2) == "manage")
    {{ Form::open(array('url' => 'phone_number/manage/'.Request::segment(3).'/update/'.$data['phone_number']->id, 'method' => 'post')) }}
    <div class="form-group">
        {{ Form::label('user_id', _('Select user')) }}
        {{ Form::select('user_id', $data['users'], $data['phone_number']->user_id, array('class' => 'form-control')) }}
    </div>
    @else
    {{ Form::open(array('url' => 'phone_number/update/'.$data['phone_number']->id, 'method' => 'post')) }}
    @endif

	<div class="form-group">
		{{ Form::label('phone_number', 'Phone Number (E.164)') }}
		{{ Form::text('phone_number', '+'.$data['global_prefix'].'-'.$data['domain']->prefix.'-'.$data['phone_number']->extension, array('class' => 'form-control', 'readonly' => true)) }}
	</div>

    <div class="form-group">
        {{ Form::label('phone_number', 'SIP Username') }}
        {{ Form::text('phone_number', $data['phone_number']->extension, array('class' => 'form-control','readonly'=>true)) }}
    </div>

    <div class="form-group">
        {{ Form::label('phone_number', 'SIP Domain') }}
        {{ Form::text('phone_number', $data['domain']->sip_server, array('class' => 'form-control','readonly'=>true)) }}
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
         <span class="input-group-addon tooltips" data-original-title="Fill the password field to change password"><span class="glyphicon glyphicon-info-sign"></span></span>
    </div>
    </div>

	<div class="form-group">
		{{ Form::label('description', 'Description') }}
		{{ Form::text('description', $data['phone_number']->description, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
    <br>
    @if(Request::segment(2) == "manage")
    <a href="{{ url('phone_number/manage/'.Request::segment(3)) }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
    @else
    <a href="{{ url('phone_number') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
    @endif
</div>
@stop

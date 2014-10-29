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
		{{ Form::text('phone_number', $data['global_prefix'].' '.$data['domain_prefix'].' '.$data['extension'], array('class' => 'form-control','readonly'=>true)) }}
	</div>

	<div class="form-group">
        {{ Form::label('phone_number', 'SIP Username') }}
        {{ Form::text('phone_number', $data['global_prefix'].$data['domain_prefix'].$data['extension'], array('class' => 'form-control','readonly'=>true)) }}
    </div>

    <div class="form-group">
        {{ Form::label('phone_number', 'SIP Domain') }}
        {{ Form::text('phone_number', Domain::find(Cookie::get('domain_hash'))->pluck('domain'), array('class' => 'form-control','readonly'=>true)) }}
    </div>

	<div class="form-group">
		{{ Form::label('description', 'Description') }}
		{{ Form::text('description', '', array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

</div>
@stop

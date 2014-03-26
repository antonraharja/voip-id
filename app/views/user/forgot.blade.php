@extends('template.skeleton')

@section('title')
@parent
@stop

@section('content')
<div class="container">
	<h1>{{ _('Forgot password') }}</h1>

	@include('template.messages')

	{{ Form::open(array('url' => 'user/forgot', 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('email', _('Email')) }}
		{{ Form::email('email', '', array('class' => 'form-control')) }}
	</div>

	{{ Form::submit(_('Submit'), array('class' => 'btn btn-primary')) }}
	
	{{ Form::close() }}
	
</div>	
@stop

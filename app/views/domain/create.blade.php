@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Add Domain') }}</h1>

	@include('template.messages')

	{{ Form::open(array('url' => 'domain/store', 'method' => 'post')) }}

	<div class="form-group">
		{{ Form::label('domain', 'Domain Name') }}
		{{ Form::text('domain', '', array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('description', 'Description') }}
		{{ Form::text('description', '', array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

</div>
@stop

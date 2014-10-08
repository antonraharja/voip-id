@extends('template.skeleton')

@section('title')
{{ _('Home') }}
@stop

@section('content')
	<div class="container">
		<h1>{{ _('Home') }}</h1>
		@include('template.messages')
	</div>	
@stop


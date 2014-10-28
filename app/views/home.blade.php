@extends('template.skeleton')

@section('title')
{{ _('Home') }}
@stop

@section('content')
	<div class="container">
		<h1>{{ _('Home') }}</h1>
		@include('template.messages')

		<div class="well">
		    We are currently in development stage.<br>
		    Data might be reset at anytime.<br>
		    Thank you for participating with us.
		</div>
	</div>	
@stop


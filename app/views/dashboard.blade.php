@extends('template.skeleton')

@section('title')
@parent
@stop

@section('content')
	<div class="container">
		<h1>{{ _('Dashboard') }}</h1>
		<p>{{ _('Logged in user') }} <strong>{{ Auth::user()->username }}</strong></p>
	</div>
@stop

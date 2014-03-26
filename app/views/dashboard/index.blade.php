@extends('template.skeleton')

@section('title')
{{ _('Dashboard') }}
@stop

@section('content')
	<div class="container">
		<h1>{{ _('Dashboard') }}</h1>
		<p>{{ _('Welcome') }} <strong>{{ Auth::user()->profile->name }}</strong><p>
		<p>{{ _('Logged in user') }} <strong>{{ Auth::user()->username }}</strong></p>
	</div>
@stop

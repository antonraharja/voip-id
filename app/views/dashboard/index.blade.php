@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Dashboard') }}
@stop

@section('content')
	<div class="container">
		<h1>{{ _('Dashboard') }}</h1>
		<p>{{ _('Welcome') }} <strong>{{ ucwords(Auth::user()->profile->first_name) }} {{ ucwords(Auth::user()->profile->last_name) }}</strong><p>
		<p>{{ _('Logged in user') }} <strong>{{ Auth::user()->username }}</strong></p>
		{{ $homepage }}
	</div>

@stop

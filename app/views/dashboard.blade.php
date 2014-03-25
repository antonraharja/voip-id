@extends('template.skeleton')

@section('title')
@parent
@stop

@section('content')
	<div class="container">
		<h1>Dashboard</h1>
		<p>Welcome {{ Auth::user()->username }}</p>
	</div>
@stop

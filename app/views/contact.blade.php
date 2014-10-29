@extends('template.skeleton')

@section('title')
{{ _('Contact us') }}
@stop

@section('content')
	<div class="container">
		<h1>{{ _('Contact us') }}</h1>
		@include('template.messages')

		<div class="well">
		    Anton Raharja antonrd@gmail.com<br>
		    Asoka Wardhana asokawardhana@gmail.com<br>
		    Yuliana Rahman ryahman@gmail.com
		</div>
	</div>	
@stop


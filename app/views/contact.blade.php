@extends('template.skeleton')

@section('title')
{{ _('Contact us') }}
@stop

@section('content')
	<div class="container">
		<h1>{{ _('Contact us') }}</h1>
		@include('template.messages')

		<div class="well">
			<p>Hubungi kami melalui Facebook Group kami <a href="https://www.facebook.com/groups/voipid/" target="_blank">disini</a>.</p>
		</div>
	</div>	
@stop


@extends('template.skeleton')

@section('title')
{{ _('Home') }}
@stop

@section('content')
	<div class="container">
		@include('template.messages')

		@if(Cookie::get('domain_hash'))
		{{ $homepage }}
		@else
		<div class="well">
			<p>VoIP ID homepage</p>
			
			<p>Admin and user manuals available at <a href="http://github.com/antonraharja/book-voip-id" target="_blank">VoIP ID Book Project</a></p>
			
			<p>Edit this page by editing <strong>app/views/home.blade.php</strong></p>
		</div>
		@endif
	</div>	
@stop

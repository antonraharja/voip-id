@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Profile') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Profile') }}</h1>

		@include('template.messages')

		{{ Form::model($profile, array('route' => array('profile.update', $profile->id), 'method' => 'PUT')) }}

		<div class="form-group">
			{{ Form::label('first_name', _('First name')) }}
			{{ Form::text('first_name', $profile->first_name, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('last_name', _('Last name')) }}
			{{ Form::text('last_name', $profile->last_name, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('website', _('Website')) }}
			{{ Form::text('website', $profile->website, array('class' => 'form-control')) }}
		</div>

		{{ Form::submit(_('Submit'), array('class' => 'btn btn-primary')) }}
		
		{{ Form::close() }}
	</div>
@stop

@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Main Configuration') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Main Configuration') }}</h1>

	@include('template.messages')

	{{ Form::open(array('url' => 'main_config/update/', 'method' => 'post')) }}
    @foreach ($settings as $setting)
	<div class="form-group">
		{{ Form::label($setting->name, ucfirst(str_replace("_"," ",$setting->name))) }}
		{{ Form::text($setting->name, $setting->value, array('class' => 'form-control')) }}
	</div>
    @endforeach
	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

</div>
@stop

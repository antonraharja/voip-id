@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

<div class="container">
	<h1>{{ _('Manage Domain') }}</h1>
	<h2>{{ _('Add Domain') }}</h2>

	@include('template.messages')

	{{ Form::open(array('url' => 'domain/store', 'method' => 'post')) }}

    @if(Auth::user()->status == 2)
        <div class="form-group">
            {{ Form::label('user_id', _('Owner')) }}
            {{ Form::select('user_id', $users, '', array('class' => 'form-control')) }}
        </div>
    @endif

    <div class="form-group">
        {{ Form::label('title', _('Domain title')) }}
        {{ Form::text('title', '', array('class' => 'form-control')) }}
    </div>

	<div class="form-group">
		{{ Form::label('domain', _('Domain name for Control Panel (DCP)')) }}
		{{ Form::text('domain', '', array('class' => 'form-control')) }}
	</div>

    <div class="form-group">
        {{ Form::label('sip_server', _('Domain name for SIP Server (DSS)')) }}
        {{ Form::text('sip_server', '', array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('allow_registration', _('Allow user registration')) }}
        {{ Form::select('allow_registration', array(1 => 'Yes', 0 => 'No'),'', array('class' => 'form-control')) }}
    </div>

	<div class="form-group">
		{{ Form::label('description', _('Description')) }}
		{{ Form::text('description', '', array('class' => 'form-control')) }}
	</div>

    <div class="form-group">
        {{ Form::label('theme', _('Theme')) }}
        {{ Form::select('theme', explode(",", str_replace(" ", "", Config::get('settings.available_css'))), '', array('class' => 'form-control')) }}
    </div>

	<div class="form-group">
        {{ Form::label('homepage', _('Homepage')) }}
        {{ Form::textarea('homepage', '', array('class' => 'form-control')) }}
    </div>

	{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
    <br>
    <a href="{{ url('domain') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
</div>
{{ HTML::script('js/tinymce/tinymce.min.js') }}
<script>
    tinymce.init({
        selector: "textarea",
        height: 300,
        menubar: false,
        statusbar: false,

        plugins: [
                    "code"
                ],
        toolbar: "code"
    });
</script>
@stop

@extends('template.skeleton')

@section('title')
{{ _('Password | Recovery') }}
@stop

@section('content')
<div class="container">

	@include('template.messages')
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-primary">
				<div class="panel-heading"><h1 class="panel-title">{{ _('Password recovery') }}</h1></div>
				<div class="panel-body">
					{{ Form::open(array('url' => 'password/recovery', 'method' => 'post')) }}

					<div class="form-group">
						{{ Form::label('email', _('Email')) }}
						{{ Form::email('email', '', array('class' => 'form-control')) }}
					</div>

					{{ Form::submit(_('Submit'), array('class' => 'btn btn-primary')) }}
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	
</div>	
@stop

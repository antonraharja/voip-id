@extends('template.skeleton')

@section('title')
{{ _('Password | Reset') }}
@stop

@section('content')
<div class="container">

	@include('template.messages')

	{{ Form::open(array('url' => 'password/reset', 'method' => 'post')) }}
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-primary">
				<div class="panel-heading"><h1 class="panel-title">{{ _('Password reset') }}</h1></div>
				<div class="panel-body">
					<div class="form-group">
						{{ Form::label('email', _('Email')) }}
						{{ Form::email('email', '', array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
                        {{ Form::label('password', _('New password')) }}
                        <div class="input-group">
                            {{ Form::password('password', array('class' => 'form-control')) }}
                            <span class="input-group-addon show-password"><span class="glyphicon glyphicon-eye-open"></span></span>
                        </div>
                    </div>

					<div class="form-group">
						{{ Form::label('token', _('Token')) }}
						{{ Form::text('token', $token, array('class' => 'form-control')) }}
					</div>

					{{ Form::submit(_('Submit'), array('class' => 'btn btn-primary')) }}
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	
</div>	
@stop

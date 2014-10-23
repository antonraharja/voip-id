@extends('template.skeleton')

@section('title')
{{ _('Register') }}
@stop

@section('content')
<div class="container">

	@include('template.messages')

	{{ Form::open(array('url' => 'register', 'method' => 'post')) }}
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-primary">
				<div class="panel-heading"><h1 class="panel-title">{{ _('Register') }}</h1></div>
				<div class="panel-body">
					<div class="form-group">
						{{ Form::label('first_name', 'First Name') }}
						{{ Form::text('first_name', '', array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('last_name', 'Last name') }}
						{{ Form::text('last_name', '', array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('email', 'Email') }}
						{{ Form::email('email', '', array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('username', 'Account ID') }}
						{{ Form::text('username', '', array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('password', 'Password') }}
						<div class="input-group">
							{{ Form::password('password', array('class' => 'form-control')) }}
							<span class="input-group-addon show-password"><span class="glyphicon glyphicon-eye-open"></span></span>
						</div>
					</div>

					{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}

</div>
@stop

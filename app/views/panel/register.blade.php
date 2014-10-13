@extends('template.skeleton')

@section('title')
{{ _('Register') }}
@stop

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>{{ _('Domain') }} : {{ $domain->domain }}</h3>
        </div>
    </div>

	@include('template.messages')

	{{ Form::open(array('url' => 'panel/'.Request::segment(2).'/save', 'method' => 'post')) }}
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
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
						{{ Form::label('username', 'Username') }}
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

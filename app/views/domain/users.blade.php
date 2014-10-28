@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Account') }}</h1>
		<h2>{{ Domain::where('id',Request::segment(3))->pluck('domain') }}</h2>

		@include('template.messages')

		<a href="{{ url('domain/users/add').'/'.Request::segment(3)  }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		<table class="table table-bordered table-striped">
			<tr>
				<th>{{ _('Account ID') }}</th>
				<th>{{ _('Name') }}</th>
				<th>{{ _('Email') }}</th>
				<th class="text-center">{{ _('Action') }}</th>
			</tr>
			@foreach ($users as $user)
			<tr>
				<td>{{ $user->username }}</td>
				<td>{{ $user->profile->first_name }} {{ $user->profile->last_name }}</td>
				<td>{{ $user->email }}</td>
				<td class="text-center action">
					<a class="tooltips" href="{{ url('users/edit/'.$user->id.'/'.$user->domain->id) }}" title="{{ _('Edit user') }}"><span class="glyphicon glyphicon-pencil"></span></a>

                    						@if ($user->flag_banned == 1)
                    							<a class="tooltips" href="{{ url('users/unban/'.$user->id.'/'.$user->domain->id) }}" title="{{ _('unban user') }}"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                    						@else
                    							<a class="tooltips" href="{{ url('users/ban/'.$user->id.'/'.$user->domain->id) }}" title="{{ _('Ban user') }}"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                    						@endif

                    					<a class="tooltips" onclick="return confirm('{{ _('Are you sure want to delete?') }}')" href="{{ url('users/delete/'.$user->id) }}" title="{{ _('Delete user') }}"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
			@endforeach
		</table>
		<a href="{{ url('domain') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
	</div>
@stop

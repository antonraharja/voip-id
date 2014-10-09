@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('User') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage User') }}</h1>

		@include('template.messages')


		<a href="{{ url('users/create') }}"><span class="glyphicon glyphicon-plus"></span></a>
		<table class="table table-bordered table-striped">
			<tr>
				<th>{{ _('Username') }}</th>
				<th>{{ _('Name') }}</th>
				<th>{{ _('Email') }}</th>
				<th class="text-center">{{ _('Action') }}</th>
			</tr>
			@foreach ($users as $user)
			<tr>
				<td>
					@if ($user->flag_banned == 1)
					<span class="glyphicon glyphicon-thumbs-down"></span>
					@endif
					{{ $user->username }}
					@if ($user->status == 2)
					<span class="glyphicon glyphicon-certificate"></span>
					@endif
				</td>
				<td>{{ $user->profile->first_name }} {{ $user->profile->last_name }}</td>
				<td>{{ $user->email }}</td>
				<td class="text-center">
					<a href="{{ url('users/edit/'.$user->id) }}" title="{{ _('Edit user') }}"><span class="glyphicon glyphicon-pencil"></span></a> 
					
						@if ($user->ban == 1)
							<a href="{{ url('users/unban/'.$user->id) }}" title="{{ _('unban user') }}"><span class="glyphicon glyphicon-thumbs-up"></span></a>
						@else
							<a href="{{ url('users/ban/'.$user->id) }}" title="{{ _('Ban user') }}"><span class="glyphicon glyphicon-thumbs-down"></span></a>
						@endif
					
					<a onclick="return confirm('{{ _('Are you sure want to delete?') }}')" href="{{ url('users/delete/'.$user->id) }}" title="{{ _('Delete user') }}"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@stop

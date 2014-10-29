@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Account') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Managers') }}</h1>

		@include('template.messages')


		<a href="{{ url('users/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		<table class="table table-bordered table-striped">
			<tr>
				<th>{{ _('Account ID') }}</th>
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
				<td class="text-center action">
					<a class="tooltips" href="{{ url('users/edit/'.$user->id) }}" title="{{ _('Edit user') }}"><span class="glyphicon glyphicon-pencil"></span></a>

						@if ($user->flag_banned == 1)
							<a class="tooltips" href="{{ url('users/unban/'.$user->id) }}" title="{{ _('unban user') }}"><span class="glyphicon glyphicon-thumbs-up"></span></a>
						@else
							<a class="tooltips" href="{{ url('users/ban/'.$user->id) }}" title="{{ _('Ban user') }}"><span class="glyphicon glyphicon-thumbs-down"></span></a> 
						@endif
					
					<a class="tooltips" onclick="return confirm('{{ _('Are you sure want to delete?') }}')" href="{{ url('users/delete/'.$user->id) }}" title="{{ _('Delete user') }}"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@stop

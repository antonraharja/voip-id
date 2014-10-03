@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('User') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('User Management') }}</h1>

		@include('template.messages')

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
					{{ $user->username }}
					@if ($user->status == 2)
					<span class="glyphicon glyphicon-certificate"></span>
					@endif
				</td>
				<td>{{ $user->profile->first_name }} {{ $user->profile->last_name }}</td>
				<td>{{ $user->email }}</td>
				<td class="text-center">
					<a href="" title="{{ _('Edit user') }}"><span class="glyphicon glyphicon-pencil"></span></a> 
					<a href="" title="{{ _('Edit profile') }}"><span class="glyphicon glyphicon-user"></span></a> 
					<a href="" title="{{ _('Delete user') }}"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@stop

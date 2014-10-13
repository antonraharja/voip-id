@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('User') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Domain') }}</h1>

		@include('template.messages')

		<a href="{{ url('domain/create') }}"><span class="glyphicon glyphicon-plus"></span> Create</a>
		<table class="table table-bordered table-striped">
			<tr>
				<th>{{ _('Hash') }}</th>
				<th>{{ _('Domain') }}</th>
				<th>{{ _('Prefix') }}</th>
				<th>{{ _('Description') }}</th>
				<th>{{ _('Share') }}</th>
				<th class="text-center">{{ _('Action') }}</th>
			</tr>
			@foreach ($domains as $domain)
			<tr>
				<td>{{ $domain->id }}</td>
				<td>{{ $domain->domain }}</td>
				<td>{{ $domain->prefix }}</td>
				<td>{{ $domain->description }}</td>
				<td>{{ url(Config::get('settings.panel_path')) }}/{{ $domain->id."/register" }}</td>
				<td class="text-center action">
					<!--<a class="tooltips" href="{{ url('users/edit/'.$domain->id) }}" title="{{ _('Edit user') }}"><span class="glyphicon glyphicon-pencil"></span></a>-->
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@stop

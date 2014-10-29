@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Domain') }}</h1>

		@include('template.messages')

		<a href="{{ url('domain/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		<table class="table table-bordered table-striped">
			<tr>
				<th>{{ _('Domain') }}</th>
				@if(Auth::user()->status == 2)
				<th>{{ _('Owner') }}</th>
				@endif
				<th>{{ _('Prefix') }}</th>
				<th>{{ _('Description') }}</th>
				<th>{{ _('Domain Control Panel') }}</th>
				<th class="text-center">{{ _('Action') }}</th>
			</tr>
			@foreach ($domains as $domain)
			<tr>
				<td>{{ $domain->domain }}</td>
				@if(Auth::user()->status == 2)
				<td>{{ User::withTrashed()->find(3)->username }}</td>
				@endif
				<td>{{ $domain->prefix }}</td>
				<td>{{ $domain->description }}</td>
				<td>{{ Form::text('description', url(Config::get('settings.panel_path')).'/'.$domain->id, array('class' => 'form-control input-sm', 'readonly')) }}</td>
				<td class="text-center action">
					<a class="tooltips" href="{{ url('domain/edit/'.$domain->id) }}" title="{{ _('Edit account') }}"><span class="glyphicon glyphicon-pencil"></span></a>
					<a class="tooltips" href="{{ url('domain/users/'.$domain->id) }}" title="{{ _('Manage users') }}"><span class="glyphicon glyphicon-user"></span></a>
					<a class="tooltips" href="{{ url('domain/delete/'.$domain->id) }}" title="{{ _('Delete domain') }}"><span class="glyphicon glyphicon-trash" onclick="return confirm('{{ _('Are you sure want to delete?') }}')"></span></a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@stop

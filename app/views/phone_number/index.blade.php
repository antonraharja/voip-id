@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Phone Number') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Phone Number') }}</h1>

		@include('template.messages')

		<a href="{{ url('phone_number/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		<table class="table table-bordered table-striped">
			<tr>
				<th>{{ _('Phone Number') }}</th>
				<th>{{ _('Account') }}</th>
				<th>{{ _('Description') }}</th>
				<th class="text-center">{{ _('Action') }}</th>
			</tr>
			@foreach ($phone_numbers as $phone_number)
			<tr>
				<td>{{ $phone_number->phone_number }}</td>
				<td>{{ $phone_number->account }}</td>
				<td>{{ $phone_number->description }}</td>
				<td class="text-center action">
				    <a class="tooltips" href="{{ url('phone_number/edit/'.$phone_number->id) }}" title="{{ _('Edit phone number') }}"><span class="glyphicon glyphicon-pencil"></span></a>
					<a class="tooltips" href="{{ url('phone_number/delete/'.$phone_number->id) }}" title="{{ _('Delete phone number') }}" onclick="return confirm('{{ _('Are you sure want to delete?') }}')"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@stop

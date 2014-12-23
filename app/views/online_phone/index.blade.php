@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Online phones') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Online Phones') }}</h1>

		@include('template.messages')

		<div  class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>{{ _('Phone numbers') }}</th>
                    <th>{{ _('Domain') }}</th>
                    <th>{{ _('Last update') }}</th>
                </tr>
                @foreach ($online_phones as $online_phone)
                <tr>
                    <td>+{{ Config::get('settings.global_prefix') }}-{{ $online_phone->domain->prefix }}-{{ $online_phone->username }}</td>
                    <td>{{ $online_phone->sip_server }}</td>
                    <td>{{ $online_phone->created_at }}</td>
                </tr>
                @endforeach
            </table>
		</div>

	</div>
@stop

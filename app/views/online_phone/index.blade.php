@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Online phones') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Online Phones') }}</h1>
        <p>Last update: {{ $online_phones[0]->created_at }}</p>

		@include('template.messages')

		<div  class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>{{ _('Phone Number (E.164)') }}</th>
                    <th>{{ _('Local Phone Number') }}</th>
                    <th>{{ _('Domain') }}</th>
                    <th>{{ _('Description') }}</th>
                </tr>
                @foreach ($online_phones as $online_phone)
                <tr>
                    <td>+{{ Config::get('settings.global_prefix') }}-{{ $online_phone->domain->prefix }}-{{ $online_phone->username }}</td>
                    <td>{{ $online_phone->username }}</td>
                    <td>{{ $online_phone->sip_server }}</td>
                    <td>{{ $online_phone->phonenumber->description }}</td>
                </tr>
                @endforeach
            </table>
		</div>

	</div>
@stop

@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Domain') }}</h1>

		@include('template.messages')

        <br>
        {{ Form::open(array('url' => 'domain/search', 'method' => 'post', 'class'=> 'form-inline')) }}

        <div class="form-group">
             @if(Auth::user()->status == 2)
            {{ Form::select('search_category', array('Search','domain' => 'Domain', 'owner' => 'Owner', 'prefix' => 'Prefix', 'description' => 'Description'), $selected['search_category'], array('class' => 'form-control input-sm')) }}
            @else
            {{ Form::select('search_category', array('Search','domain' => 'Domain', 'prefix' => 'Prefix', 'description' => 'Description'), $selected['search_category'], array('class' => 'form-control input-sm')) }}
            @endif
        </div>

        <div class="form-group">
            {{ Form::text('search_keyword', $selected['search_keyword'], array('class' => 'form-control input-sm')) }}
        </div>

        {{ Form::submit('Search', array('class' => 'btn btn-primary btn-sm')) }}

        {{ Form::close() }}
        <br>

        @if(Auth::user()->status!=2)
		<a href="{{ url('domain/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		@endif
		<div  class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    @if(Auth::user()->status == 2)
                    <th>{{ _('Owner') }}</th>
                    @endif
                    <th>{{ _('Domain name for Control Panel (DCP)') }}</th>
                    <th>{{ _('Domain name for SIP Server (DSS)') }}</th>
                    <th>{{ _('Prefix') }}</th>
                    <th>{{ _('Description') }}</th>
                    <th class="text-center">{{ _('Action') }}</th>
                </tr>
                @foreach ($domains as $domain)
                <tr>
                    @if(Auth::user()->status == 2)
                    <td>{{ $domain->user->username }}</td>
                    @endif
                    <td><a target="_blank" href="http://{{ $domain->domain }}">http://{{ $domain->domain }}</a></td>
                    <td>{{ $domain->sip_server }}</td>
                    <td>+{{ Config::get('settings.global_prefix') }}-{{ $domain->prefix }}</td>
                    <td>{{ $domain->description }}</td>
                    <td class="text-center action">
                        <a class="tooltips" href="{{ url('domain/edit/'.$domain->id) }}" title="{{ _('Edit account') }}"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="tooltips" href="{{ url('domain/users/'.$domain->id) }}" title="{{ _('Manage users') }}"><span class="glyphicon glyphicon-user"></span></a>
                        <a class="tooltips" href="{{ url('phone_number/manage/'.$domain->id) }}" title="{{ _('Manage phone number') }}"><span class="glyphicon glyphicon-phone-alt"></span></a>
                        <a class="tooltips" href="{{ url('domain/delete/'.$domain->id) }}" title="{{ _('Delete domain') }}"><span class="glyphicon glyphicon-trash" onclick="return confirm('{{ _('Are you sure want to delete?') }}')"></span></a>
                    </td>
                </tr>
                @endforeach
            </table>
		</div>

	</div>
@stop

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
            {{ Form::select('search_category', array('Search','domain' => 'Domain', 'prefix' => 'Prefix', 'description' => 'Description'), $selected['search_keyword'], array('class' => 'form-control input-sm')) }}
            @endif
        </div>

        <div class="form-group">
            {{ Form::text('search_keyword', '', array('class' => 'form-control input-sm')) }}
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
                    <td>{{ $domain->user->username }}</td>
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

	</div>
@stop

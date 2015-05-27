@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Token') }}</h1>

		@include('template.messages')

        <br>
        {{ Form::open(array('url' => 'token/search', 'method' => 'post', 'class'=> 'form-inline')) }}

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

        {{ Form::submit('Generate', array('class' => 'btn btn-primary btn-sm')) }}

        {{ Form::close() }}
        <br>

		<a href="{{ url('token/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		<!-- <div  class="table-responsive"> -->
            <table id="enable_pagination" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead> <tr>
                    @if(Auth::user()->status == 2)
                    <th>{{ _('Owner') }}</th>
                    @endif
                    <th>{{ _('Token') }}</th>
                    <th>{{ _('Created At') }}</th>
                    <th class="text-center">{{ _('Action') }}</th>
                </tr></thead>
                <tbody>
                @foreach ($domains as $domain)
                <tr>
                    @if(Auth::user()->status == 2)
                    <td>{{ $domain->user->username }}</td>
                    @endif
                    <td><a target="_blank" href="http://{{ $domain->domain }}">http://{{ $domain->domain }}</a></td>
                    <td>{{ $domain->sip_server }}</td>
                    <td class="text-center action">
                        <a class="tooltips" href="{{ url('domain/delete/'.$domain->id) }}" title="{{ _('Delete token') }}"><span class="glyphicon glyphicon-trash" onclick="return confirm('{{ _('Are you sure want to delete?') }}')"></span></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
		<!-- </div> -->

	</div>
    
@stop

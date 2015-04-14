@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Users') }}</h1>
		<h2>Domain {{ Domain::find(Request::segment(3))->domain }}</h2>

		@include('template.messages')

        <br>
        {{ Form::open(array('url' => 'domain/users/'.Request::segment(3).'/search', 'method' => 'post', 'class'=> 'form-inline')) }}

        <div class="form-group">
            {{ Form::select('search_category', array('Search', 'username' => 'Account ID', 'name' => 'Name', 'email' => 'Email'), $selected['search_category'], array('class' => 'form-control input-sm')) }}
        </div>

        <div class="form-group">
            {{ Form::text('search_keyword', $selected['search_keyword'], array('class' => 'form-control input-sm')) }}
        </div>

        {{ Form::submit('Search', array('class' => 'btn btn-primary btn-sm')) }}

        {{ Form::close() }}

        <br>

		<a href="{{ url('users/add').'/'.Request::segment(3)  }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		<table id="enable_pagination" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead><tr>
                    <th>{{ _('Account ID') }}</th>
                    <th>{{ _('Name') }}</th>
                    <th>{{ _('Email') }}</th>
                    <th class="text-center">{{ _('Action') }}</th>
                </tr></thead><tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->profile->first_name }} {{ $user->profile->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center action">
                        <a class="tooltips" href="{{ url('users/edit/'.$user->id.'/'.$user->domain_id) }}" title="{{ _('Edit user') }}"><span class="glyphicon glyphicon-pencil"></span></a>

                            @if ($user->flag_banned == 1)
                                <a class="tooltips" href="{{ url('users/unban/'.$user->id.'/'.$user->domain_id) }}" title="{{ _('unban user') }}"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                            @else
                                <a class="tooltips" href="{{ url('users/ban/'.$user->id.'/'.$user->domain_id) }}" title="{{ _('Ban user') }}"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                            @endif

                        <a class="tooltips" onclick="return confirm('{{ _('Are you sure want to delete?') }}')" href="{{ url('users/delete/'.$user->id.'/'.$user->domain_id) }}" title="{{ _('Delete user') }}"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
		
		<a href="{{ url('domain') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
	</div>
@stop

@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Account') }}
@stop

@section('content')

	<div class="container">
        @if(Request::segment(1)=="managers")
		<h1>{{ _('Manage Managers') }}</h1>
		@endif

		@if(Request::segment(1)=="users")
        <h1>{{ _('Manage Users') }}</h1>
        @endif

		@include('template.messages')

        <br>
        @if(Request::segment(1)=="managers")
        {{ Form::open(array('url' => 'managers/search', 'method' => 'post', 'class'=> 'form-inline')) }}
        @else
        {{ Form::open(array('url' => 'users/search', 'method' => 'post', 'class'=> 'form-inline')) }}
        @endif

        <div class="form-group">
            {{ Form::select('search_category', array('Search','owner' => 'Manager', 'username' => 'Account ID', 'name' => 'Name', 'email' => 'Email'), $selected['search_category'], array('class' => 'form-control input-sm')) }}
        </div>

        <div class="form-group">
            {{ Form::text('search_keyword', $selected['search_keyword'], array('class' => 'form-control input-sm')) }}
        </div>

        {{ Form::submit('Search', array('class' => 'btn btn-primary btn-sm')) }}

        {{ Form::close() }}

        <br>

		<a href="{{ url('users/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		<div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    @if(Request::segment(1)=="users")
                    <th>{{ _('Manager') }}</th>
                    @endif
                    <th>{{ _('Account ID') }}</th>
                    <th>{{ _('Name') }}</th>
                    <th>{{ _('Email') }}</th>
                    <th class="text-center">{{ _('Action') }}</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    @if(Request::segment(1)=="users")
                    <td>{{ $user->domain->user->username }}</td>
                    @endif
                    <td>
                        @if ($user->flag_banned == 1)
                        <span class="glyphicon glyphicon-thumbs-down"></span>
                        @endif
                        {{ $user->username }}
                        @if ($user->status == 2)
                        <span class="glyphicon glyphicon-certificate"></span>
                        @endif
                    </td>
                    <td>{{ $user->profile->first_name }} {{ $user->profile->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center action">
                        <a class="tooltips" href="{{ url('users/edit/'.$user->id) }}" title="{{ _('Edit user') }}"><span class="glyphicon glyphicon-pencil"></span></a>

                            @if ($user->flag_banned == 1)
                                <a class="tooltips" href="{{ url('users/unban/'.$user->id) }}" title="{{ _('unban user') }}"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                            @else
                                <a class="tooltips" href="{{ url('users/ban/'.$user->id) }}" title="{{ _('Ban user') }}"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                            @endif

                        <a class="tooltips" onclick="return confirm('{{ _('Are you sure want to delete?') }}')" href="{{ url('users/delete/'.$user->id) }}" title="{{ _('Delete user') }}"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
                @endforeach
            </table>
		</div>
	</div>
@stop

@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Phone Number') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Phone Number') }}</h1>
		@if(Request::segment(2))
		<h2>Domain {{ Domain::find(Request::segment(3))->domain }}</h2>
		@endif

		@include('template.messages')

		<br>
        {{ Form::open(array('url' => 'phone_number/search', 'method' => 'post', 'class'=> 'form-inline')) }}

        <div class="form-group">
            {{ Form::select('search_category', array('Search', 'extension' => 'Phone Number', 'description' => 'Description'), $selected['search_category'], array('class' => 'form-control input-sm')) }}
        </div>

        <div class="form-group">
            {{ Form::text('search_keyword', $selected['search_keyword'], array('class' => 'form-control input-sm')) }}
        </div>

        {{ Form::submit('Search', array('class' => 'btn btn-primary btn-sm')) }}

        {{ Form::close() }}

        <br>

        @if(Request::segment(2))
		<a href="{{ url('phone_number/manage/'.Request::segment(3).'/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		@else
		<a href="{{ url('phone_number/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		@endif
		<div class="table-responsive">
		    <table id="enable_pagination" class="table table-bordered table-striped">
                <thead><tr>
                    @if(Request::segment(2))
                    <th>{{ _('Owner') }}</th>
                    @endif
                    <th>{{ _('E164 Phone Number') }}</th>
                    <th>{{ _('Local Phone Number') }}</th>
                    <th>{{ _('Description') }}</th>
                    <th class="text-center">{{ _('Action') }}</th>
                </tr></thead><tbody>
                @foreach ($phone_numbers as $phone_number)
                <tr>
                    @if(Request::segment(2))
                    <td>{{ $phone_number->user->username }}</td>
                    @endif
                    <td>+{{ Config::get('settings.global_prefix') }}-{{ $phone_number->user->domain->prefix }}-{{ $phone_number->extension }}</td>
                    <td>{{ $phone_number->extension }}</td>
                    <td>{{ $phone_number->description }}</td>
                    <td class="text-center action">
                        <a class="popinfo" data-container="body" data-toggle="popover" data-placement="left" data-content="@include('phone_number.popover')"><span class="glyphicon glyphicon-info-sign"></span></a>
                        @if(Request::segment(2))
                        <a class="tooltips" href="{{ url('phone_number/manage/'.Request::segment(3).'/edit/'.$phone_number->id) }}" title="{{ _('Edit phone number') }}"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="tooltips" href="{{ url('phone_number/manage/'.Request::segment(3).'/delete/'.$phone_number->id) }}" title="{{ _('Delete phone number') }}" onclick="return confirm('{{ _('Are you sure want to delete?') }}')"><span class="glyphicon glyphicon-trash"></span></a>
                        @else
                        <a class="tooltips" href="{{ url('phone_number/edit/'.$phone_number->id) }}" title="{{ _('Edit phone number') }}"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="tooltips" href="{{ url('phone_number/delete/'.$phone_number->id) }}" title="{{ _('Delete phone number') }}" onclick="return confirm('{{ _('Are you sure want to delete?') }}')"><span class="glyphicon glyphicon-trash"></span></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
		</div>
        <a href="{{ url('domain') }}"><span class="glyphicon glyphicon-arrow-left"></span> {{ _('Back') }}</a>
	</div>
@stop

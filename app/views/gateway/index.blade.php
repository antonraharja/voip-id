@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('gateway') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Gateway') }}</h1>

		@include('template.messages')

        <br>
        {{ Form::open(array('url' => 'gateway/search', 'method' => 'post', 'class'=> 'form-inline')) }}

        <div class="form-group">
            {{ Form::select('search_category', array('Search','gateway_name' => 'Gateway name', 'gateway_address' => 'Gateway address', 'prefix' => 'Prefix'), $selected['search_category'], array('class' => 'form-control input-sm')) }}
        </div>

        <div class="form-group">
            {{ Form::text('search_keyword', $selected['search_keyword'], array('class' => 'form-control input-sm')) }}
        </div>

        {{ Form::submit('Search', array('class' => 'btn btn-primary btn-sm')) }}

        {{ Form::close() }}
        <br>


		<a href="{{ url('gateway/add') }}"><span class="glyphicon glyphicon-plus"></span> {{ _('Add') }}</a>
		
            table id="enable_pagination" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%"
                <thead><tr>
                    @if(Auth::user()->status == 2)
                    <th>{{ _('Owner') }}</th>
                    @endif
                    <th>{{ _('Gateway name') }}</th>
                    <th>{{ _('Gateway address') }}</th>
                    <th>{{ _('Prefix') }}</th>
                    <th class="text-center">{{ _('Action') }}</th>
                </tr></thead><tbody>
                @foreach ($gateways as $gateway)
                <tr>
                    @if(Auth::user()->status == 2)
                    <td>{{ $gateway->user->username }}</td>
                    @endif
                    <td>{{ $gateway->gateway_name }}</td>
                    <td>{{ $gateway->gateway_address }}</td>
                    <td>+{{ Config::get('settings.global_prefix') }}-{{ $gateway->prefix }}</td>
                    <td class="text-center action">
                        <a class="tooltips" href="{{ url('gateway/edit/'.$gateway->id) }}" title="{{ _('Edit gateway') }}"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="tooltips" href="{{ url('gateway/delete/'.$gateway->id) }}" title="{{ _('Delete gateway') }}"><span class="glyphicon glyphicon-trash" onclick="return confirm('{{ _('Are you sure want to delete?') }}')"></span></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
		

	</div>
@stop

@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Domain') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Manage Token') }}</h1>

		@include('template.messages')

        <br>
        {{ Form::open(array('url' => 'token', 'method' => 'post', 'class'=> 'form-inline')) }}

        <div class="form-group">
             Keyword
        </div>

        <div class="form-group">
            {{ Form::text('keyword', '', array('class' => 'form-control input-sm')) }}
        </div>

        {{ Form::submit('Generate', array('class' => 'btn btn-primary btn-sm')) }}

        {{ Form::close() }}
        <br>

		<!-- <div  class="table-responsive"> -->
            <table id="enable_pagination" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead> <tr>
                    
                    <th>{{ _('Token') }}</th>
                    <th>{{ _('Created At') }}</th>
                    <th class="text-center">{{ _('Action') }}</th>
                </tr></thead>
                <tbody>
                @foreach ($tokens as $token)
                <tr>
                    <td>{{ $token->token }}</a></td>
                    <td>{{ $token->created_at }}</td>
                    <td class="text-center action">
                        <a class="tooltips" href="{{ url('token/delete/'.$token->id) }}" title="{{ _('Delete token') }}"><span class="glyphicon glyphicon-trash" onclick="return confirm('{{ _('Are you sure want to delete?') }}')"></span></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
		<!-- </div> -->

	</div>
    
@stop

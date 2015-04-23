@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Call Detail Reports') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Call Detail Reports') }}</h1>
       

		@include('template.messages')
		
		<br>
        {{ Form::open(array('url' => 'call_detail_reports/filter', 'method' => 'post', 'class'=> 'form-inline')) }}


        <div class="row">
            {{ Form::checkbox('datefilter', 'value'); }}
			{{ Form::label('date', 'Date : ');}}
			{{ Form::text('datefrom', null, array('type' => 'text',
						'class' => 'form-control datePicker',
						'placeholder' => 'Begin Date',
						'name' => 'datefrom'
						)) }}
            {{Form::label('dateto', 'To : ');}}
            {{ Form::text('dateto', null, array('type' => 'text',
						'class' => 'form-control datePicker',
						'placeholder' => 'End Date',
						'name' => 'dateto'
						)) }}
        </div><br>
        <div class="row">
            {{ Form::checkbox('timefilter', 'value'); }}
			{{Form::label('time', 'Time : ');}}
            {{ Form::text('timefrom', '', array('class' => 'form-control input-sm timepicker',
            			'type' => 'text',
						'placeholder' => 'Start Time',
						'name' => 'timefrom'
            			)) }}
            {{Form::label('timeto', 'To : ');}}
            {{ Form::text('timeto', '', array('class' => 'form-control input-sm timepicker',
            			'type' => 'text',
						'placeholder' => 'End Time',
						'name' => 'timeto'
            			)) }}
        </div><br>
        
        <div class="row">
             {{ Form::checkbox('durationfilter', 'value'); }}
			 {{Form::label('duration', 'Duration : ');}}
			 {{ Form::select('durationparam', array('<' => '<', '<=' => '<=', '>=' => '>=', '>' => '>'), '=',array('class' => 'form-control input-sm')) }}
			 {{ Form::text('duration', '', array('class' => 'form-control input-sm duration',
            			'type' => 'text',
						'placeholder' => 'Duration Time',
						'name' => 'duration'
            			)) }}
        </div><br>
        <div class="row">
             {{ Form::checkbox('fromfilter', 'value'); }}
			 {{Form::label('from', 'From : ');}}
			 {{ Form::text('from', '', array('class' => 'form-control input-sm',
			 			'type' => 'text',
						'placeholder' => 'Caller ID',
						'name' => 'from'
			 			)) }}            
        </div><br>
        <div class="row">
             {{ Form::checkbox('tofilter', 'value'); }}
			 {{Form::label('to', 'To : ');}}
             {{ Form::text('to', '', array('class' => 'form-control input-sm',
             			'type' => 'text',
						'placeholder' => 'Receiver ID',
						'name' => 'to'
             			)) }}
            
        </div><br>
        

        {{ Form::submit('Search', array('class' => 'btn btn-primary btn-sm')) }}

        {{ Form::close() }}
        <br>
        

		<table id="enable_pagination" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead><tr>
                    <th>{{ _('Date') }}</th>
                    <th>{{ _('Time') }}</th>
                    <th>{{ _('From') }}</th>
                    <th>{{ _('To') }}</th>
                    <th>{{ _('Duration') }}</th>
                </tr></thead><tbody>
                @foreach ($call_detail_reports as $call_detail_reports)
                <tr>
                    <td>{{ substr(substr($call_detail_reports->call_start_time,0,10),-2) }}-{{ substr(substr($call_detail_reports->call_start_time,0,10),-5,2) }}-{{ substr(substr($call_detail_reports->call_start_time,0,10),0,4) }}
                    </td>
                    <td>{{ substr($call_detail_reports->call_start_time,-8) }}</td>
                    <td>{{ $call_detail_reports->src_uri }}{{ '@'.$call_detail_reports->caller_domain }}</td>
                    <td>{{ $call_detail_reports->dst_uri }}{{ '@'.$call_detail_reports->callee_domain }}</td>
                    <td>{{ gmdate("H:i:s",$call_detail_reports->duration) }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
		

	</div>
@stop

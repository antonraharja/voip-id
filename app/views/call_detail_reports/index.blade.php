@extends('template.skeleton')

@section('title')
{{ Auth::user()->username.' | '._('Call Detail Reports') }}
@stop

@section('content')

	<div class="container">

		<h1>{{ _('Call Detail Reports') }}</h1>
       

		@include('template.messages')
		
		
	<div class="container">
        {{ Form::open(array('url' => 'call_detail_reports/filter', 'method' => 'post', 'class'=> 'form-inline')) }}
        <div class="row">
        	<div class="col-md-8">
        		<div class="col-md-4">
        			<div class="col-md-4">
        			</div>
        			<div class="col-md-8">
        			{{ Form::checkbox('datefilter', 'value'); }}
					{{ Form::label('date', 'Date');}}
        			</div>
        		</div>
        		<div class="col-md-8">
        		{{ Form::text('datefrom', null, array('type' => 'text',
						'class' => 'form-control input-sm datePicker',
						'placeholder' => 'Begin Date',
						'name' => 'datefrom'
						)) }}
				{{Form::label('dateto', 'To');}}
				{{ Form::text('dateto', null, array('type' => 'text',
						'class' => 'form-control input-sm datePicker',
						'placeholder' => 'End Date',
						'name' => 'dateto'
						)) }}
        		</div>	
        	</div>
        	<div class="col-md-4">
            </div>
        </div><br>
        
        <div class="row">
        	<div class="col-md-8">
        		<div class="col-md-4">
        			<div class="col-md-4">
        			</div>
        			<div class="col-md-8">
		            {{ Form::checkbox('timefilter', 'value'); }}
					{{Form::label('time', 'Time');}}
					</div>
        		</div>
        		<div class="col-md-8">
	            {{ Form::text('timefrom', '', array('class' => 'form-control input-sm timepicker',
	            			'type' => 'text',
							'placeholder' => 'Start Time',
							'name' => 'timefrom'
	            			)) }}
	            {{Form::label('timeto', 'To   ');}}
	            {{ Form::text('timeto', '', array('class' => 'form-control input-sm timepicker',
	            			'type' => 'text',
							'placeholder' => 'End Time',
							'name' => 'timeto'
	            			)) }}
        		</div>
            </div>
            <div class="col-md-4"></div>
        </div><br>
        
        <div class="row">
        	<div class="col-md-8">
        		<div class="col-md-4">
        			<div class="col-md-4">
        			</div>
        			<div class="col-md-8">
		             {{ Form::checkbox('durationfilter', 'value'); }}
					 {{Form::label('duration', 'Duration');}}
					 </div>
        		</div>
        		<div class="col-md-8">
				 {{ Form::select('durationparam', array('<' => '<', '<=' => '<=', '>=' => '>=', '>' => '>'), '=',array('class' => 'form-control input-sm')) }}
				 {{ Form::text('duration', '', array('class' => 'form-control input-sm duration',
	            			'type' => 'text',
							'placeholder' => 'Duration Time',
							'name' => 'duration'
	            			)) }}
	            </div>
            </div>
            <div class="col-md-4"></div>
        </div><br>
        <div class="row">
        	<div class="col-md-8">
        		<div class="col-md-4">
        			<div class="col-md-4">
        			</div>
        			<div class="col-md-8">
		             {{ Form::checkbox('fromfilter', 'value'); }}
					 {{Form::label('from', 'From');}}
					 </div>
        		</div>
        		<div class="col-md-8">
				 {{ Form::text('from', '', array('class' => 'form-control input-sm',
				 			'type' => 'text',
							'placeholder' => 'Caller ID',
							'name' => 'from'
				 			)) }}  
				</div>
            </div>
            <div class="col-md-4"></div>
        </div><br>
        <div class="row">
        	<div class="col-md-8">
        		<div class="col-md-4">
        			<div class="col-md-4">
        			</div>
        			<div class="col-md-8">
		             {{ Form::checkbox('tofilter', 'value'); }}
					 {{Form::label('to', 'To');}}
					  </div>
        		</div>
        		<div class="col-md-8">
	             {{ Form::text('to', '', array('class' => 'form-control input-sm',
	             			'type' => 'text',
							'placeholder' => 'Receiver ID',
							'name' => 'to'
	             			)) }}
				 </div>
            </div>
            <div class="col-md-4"></div>
        </div><br>
        
		<div class="row">
			<div class="col-md-8">
        		<div class="col-md-4">
        			
        		</div>
        		<div class="col-md-8">
        		{{Form::button('<i class="fa fa-search fa-fw"></i> Search', array('type' => 'submit', 'class' => 'btn btn-primary btn-sm pull-right'))}}
				</div>
            </div>
            <div class="col-md-4"></div>
		</div>
        {{ Form::close() }}
        
        
	</div>
	
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

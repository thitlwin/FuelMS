@extends('layouts.app')

@section('contentheader')
	@section('contentheader_title')	
		{{ trans('setting.unit_setting') }}		
	@endsection	
@endsection
@section('breadcumb')
		<li class="active">{{ trans('setting.unit_setting') }}</li>     
@endsection

@section('content')
<div class="container-fluid full-screen">		
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">{{ trans('form.measurement_unit_setting') }}</div>
			<div class="panel-body">						 
			    {!! Form::open(['route'=>'unit_settings.update','method'=>'POST']) !!}						
				<div class="col-md-3"></div>
				<div class="col-md-6">
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('w_report_unit',trans('setting.w_report_unit'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::select('w_report_unit',getMeasurementUnits(),$selected_w_unit,array('class'=>'form-control')) }}
								</div>
							</div>								
						</div>

						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('wh_report_unit',trans('setting.wh_report_unit'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::select('wh_report_unit',getMeasurementUnits(),$selected_wh_unit,array('class'=>'form-control')) }}
								</div>
							</div>								
						</div>

						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('dashboard_unit',trans('setting.dashboard_unit'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::select('dashboard_unit',getMeasurementUnits(),$selected_dashboard_unit,array('class'=>'form-control')) }}
								</div>
							</div>								
						</div>
						 
						 <div class="form-group">
							<div class="row">								
								<div class="col-md-9 col-md-offset-3">
									{{Form::submit(trans('form.update'),['class'=>'btn btn-primary'])}}
									{{Form::reset(trans('form.reset'),['class'=>'btn btn-warning'])}}
								</div>
							</div>								
							</div>
						</div>
					    <div class="col-md-3"></div>
					{!! Form::close() !!}
		    </div>					
        </div>
    </div>
</div>
	
@endsection

@section('footer_scripts')
@endsection

							
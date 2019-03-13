@extends('layouts.app')

@section('contentheader')
	@section('contentheader_title')	
		{{ trans('dashboard.dashboard_setting') }}		
	@endsection	
@endsection
@section('breadcumb')
		<li class="active">{{ trans('form.edit') }}</li>     
@endsection

@section('content')
<div class="container-fluid full-screen">		
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">{{ trans('form.form_edit') }}</div>
			<div class="panel-body">						 
			    {!! Form::open(['route'=>'dashboard_setting.update','method'=>'POST','id'=>'range_update_form']) !!}						
				<div class="col-md-3"></div>
				<div class="col-md-6">
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('db_update_second',trans('dashboard.db_update_second'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('db_update_second',$dashboardSetting['db_update_second'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
								</div>
							</div>								
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('interval_chart_second',trans('dashboard.interval_chart_second'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('interval_chart_second',$dashboardSetting['interval_chart_second'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
								</div>
							</div>								
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('chart_width',trans('dashboard.chart_width'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('chart_width',$dashboardSetting['chart_width'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
								</div>
							</div>								
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('chart_height',trans('dashboard.chart_height'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('chart_height',$dashboardSetting['chart_height'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
								</div>
							</div>								
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('minor_ticks',trans('dashboard.minor_ticks'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('minor_ticks',$dashboardSetting['minor_ticks'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
								</div>
							</div>								
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('red_from',trans('dashboard.red_from'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('red_from',$dashboardSetting['red_from'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
								</div>
							</div>								
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('red_to',trans('dashboard.red_to'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('red_to',$dashboardSetting['red_to'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
								</div>
							</div>								
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('yellow_from',trans('dashboard.yellow_from'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('yellow_from',$dashboardSetting['yellow_from'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
								</div>
							</div>								
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-md-3 align_center_right">
							{{ Form::label('yellow_to',trans('dashboard.yellow_to'),array('class'=>'control-label'))}}	
							</div>
								<div class="col-md-9">
									{{ Form::text('yellow_to',$dashboardSetting['yellow_to'],array('class'=>'form-control','placeholder'=>'Unit name')) }}			
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
</div>
	
@endsection

@section('footer_scripts')
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
 {!! JsValidator::formRequest('PowerMs\Http\Requests\DashboardSettingRequest', '#range_update_form'); !!}

 @endsection

							
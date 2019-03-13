@extends('layouts.app')

@section('contentheader_title')	

@endsection

@section('breadcumb')
		<li><a href="{{url('control-panel/device')}}">{{ trans('device.device') }}</a></li> 
		<li class="active">{{ trans('form.create') }}</li>     
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
		 		<div class="panel panel-default">
					<div class="panel-heading">{{ trans('form.form_create') }}</div>
					<div class="panel-body">						 

					{!! Form::open(['route'=>'device.save','method'=>'POST','id'=>'device_create_form']) !!}						
						<div class="col-md-3"></div>
						<div class="col-md-6">
					
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	
                            
                            <div class="form-group">
								<div class="row" >
								<div class="col-md-3 align_center_right">
								{{ Form::label('mode',trans('Mode'),array('class'=>'control-label'))}}	
								</div>
								<div class="col-md-1">
									{{ Form::radio('mode', 'value'),array('class'=>'form-control') }}								
								</div>
								<div class="col-md-4">
								{{ Form::label('ap',trans('AP'),array('class'=>'control-label'))}}	
								</div>
							    <div class="col-md-1 align_center_right">
								{{ Form::radio('mode', 'value') }}
								</div>
								<div class="col-md-3">
									{{ Form::label('wifi',trans('Wifi'),array('class'=>'form-control','class'=>'control-label'))}}									
								</div>
								</div>								
							</div>

							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('ssid',trans('SSID'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-9">
										{{ Form::text('ssid','',array('class'=>'form-control','placeholder'=>trans('SSID'))) }}								
									</div>
								</div>								
							</div>
							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('password',trans('user.password'),array('class'=>'control-label'))}}
								</div>
									<div class="col-md-9">
										{{ Form::password('password',['class'=>'form-control','placeholder'=>trans('user.password')]) }}
									</div>
							</div>
							</div>
							
							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('dhcp',trans('DHCP'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-5">
										{{ Form::radio('dhcp_static', 'value'),array('class'=>'form-control') }}								
									</div>
							    <div class="col-md-1 align_center_right" >
								{{ Form::radio('dhcp_static', 'value') }}
								</div>
								<div class="col-md-2">
									{{ Form::label('static',trans('STATIC'),array('class'=>'form-control','class'=>'control-label'))}}									
								</div>
								</div>								
							</div>

							<div class="form-group">
							<div class="row">								
								<div class="col-md-9 col-md-offset-3">
									{{Form::submit(trans('form.save'),['class'=>'btn btn-primary'])}}
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
 <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
 {!! JsValidator::formRequest('PowerMs\Http\Requests\DeviceRequest', '#device_create_form'); !!}
@endsection
@extends('layouts.app')

@section('contentheader_title')	
	
@endsection
@section('breadcumb')
        <li><a href="{{url('control-panel/device')}}">{{ trans('device.device') }}</a></li>
		<li class="active">{{ trans('form.edit') }}</li>     
@endsection

@section('content')
	<div class="container-fluid full-screen">		
					<div class="row">
								 <div class="panel panel-default">
									<div class="panel-heading">{{ trans('form.form_edit') }}</div>
									<div class="panel-body">						 
								 
							{!! Form::open(['route'=>'device.update','method'=>'POST','id'=>'device_update_form']) !!}						
													
						<div class="col-md-3"></div>
						<div class="col-md-6">
					
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	
					{{Form::hidden('id',$device_edit->id)}}
							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('name',trans('device.name'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-9">
										{{ Form::text('name',$device_edit->name,array('class'=>'form-control','placeholder'=>trans('device.name'))) }}			
									</div>
								</div>								
							</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('location',trans('device.location'),array('class'=>'control-label'))}}
								</div>
							<div class="col-md-9">

								{{Form::select('location_id',$location,$device_edit->location_id,['class'=>'form-control'],array('class'=>'form-control'))}}
								
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
	
@endsection

@section('footer_scripts')
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
 {!! JsValidator::formRequest('PowerMs\Http\Requests\DeviceRequest', '#device_update_form'); !!}

 @endsection

							
@extends('layouts.app')

@section('contentheader_title')	

@endsection

@section('breadcumb')
		<li><a href="{{url('control-panel/location')}}">{{trans('location.location')}}</a></li> 
		<li class="active">{{ trans('form.create') }}</li>     
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
		 		<div class="panel panel-default">
					<div class="panel-heading">{{ trans('form.form_create') }}</div>
					<div class="panel-body">						 

					{!! Form::open(['route'=>'location.save','method'=>'POST','id'=>'location_create_form']) !!}						
						<div class="col-md-3"></div>
						<div class="col-md-6">
					
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	

							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('location_name',trans('location.name'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-9">
										{{ Form::text('location_name','',array('class'=>'form-control','placeholder'=>trans('location.name'))) }}								
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
 {!! JsValidator::formRequest('PowerMs\Http\Requests\LocationRequest', '#location_create_form'); !!}
@endsection
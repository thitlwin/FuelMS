@extends('layouts.app')

@section('contentheader_title')	

@endsection

@section('breadcumb')
		<li><a href="{{url('control-panel/range')}}">{{trans('range.range')}}</a></li> 
		<li class="active">{{ trans('form.create') }}</li>     
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
		 		<div class="panel panel-default">
					<div class="panel-heading">{{ trans('form.form_create') }}</div>
					<div class="panel-body">						 

					{!! Form::open(['route'=>'range.save','method'=>'POST','id'=>'range_create_form']) !!}						
						<div class="col-md-3"></div>
						<div class="col-md-6">
					
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	

							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('unit_name',trans('range.name'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-9">
										{{ Form::text('unit_name','',array('class'=>'form-control','placeholder'=>trans('range.name'))) }}								
									</div>
								</div>								
							</div>

							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('min',trans('range.min'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-9">
										{{ Form::text('min','',array('class'=>'form-control','placeholder'=>trans('range.min'))) }}								
									</div>
								</div>								
							</div>
							
							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('max',trans('range.max'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-9">
										{{ Form::text('max','',array('class'=>'form-control','placeholder'=>trans('range.max'))) }}								
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
 {!! JsValidator::formRequest('PowerMs\Http\Requests\RangeRequest', '#range_create_form'); !!}
@endsection
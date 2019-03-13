@extends('layouts.app')

@section('contentheader_title')	
	{{ trans('product.product') }}
@endsection

@section('breadcumb')
		<li><a href="{{url('products')}}">{{ trans('product.product') }}</a></li> 
		<li class="active">{{ trans('form.create') }}</li>     
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
		 		<div class="panel panel-default">
					<div class="panel-heading">{{ trans('form.form_create') }}</div>
					<div class="panel-body">						 
				 
					{!! Form::open(['route'=>'qrcode.save','method'=>'POST','id'=>'product_create_form']) !!}						
						<div class="col-md-3"></div>
						<div class="col-md-6">					
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>	

							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('encrypt',trans('Encrypt'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-9">
										{{ Form::text('encrypt','',array('class'=>'form-control','placeholder'=>trans('Encrypt'))) }}								
									</div>
								</div>								
							</div>
							    
							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('filename',trans('Filename'),array('class'=>'control-label'))}}
								</div>
								<div class="col-md-9">
								{{ Form::text('filename','',array('class'=>'form-control','placeholder'=>trans('File Name'))) }}
								</div>
								</div>
							</div>	

							<div class="form-group">
							<div class="row">								
								<div class="col-md-9 col-md-offset-3">
									{{Form::submit(trans('Generate'),['class'=>'btn btn-primary'])}}
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
	@include('script_datetime_picker')
	<script type="text/javascript">
	$('.form_date').datetimepicker({
	        // language:  'fr',
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
	    });
	</script>
 <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
 {!! JsValidator::formRequest('prjsmarthome\Http\Requests\QRcodeRequest', '#product_create_form'); !!}
@endsection
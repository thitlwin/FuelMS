@extends('layouts.app')

@section('contentheader_title')	
	{{ trans('user.profile') }}
@endsection
@section('breadcumb')		
		<li class="active">{{ trans('user.profile') }}</li>     
@endsection

@section('content')
	<div class="container-fluid full-screen">
		<div class="row">			
				<div class="panel panel-default">
					<div class="panel-heading">{{ trans('form.form_edit') }}</div>					
					<div class="panel-body">						 				
				<?php
				$ut=[];
				foreach ($user_types as $t) {
					$ut[$t['id']]=$t['name'];
				}
				 ?>
				 <div class="col-md-12">
				 	@include('vendor.toast.messages')
					 	<?php Session::forget('toasts'); ?>	
				 </div>
					{!! Form::open(['route'=>'user.update','method'=>'POST','id'=>'user_update_form']) !!}		
					{{ Form::hidden('id',$user->id) }}															
						<div class="col-md-7">
						 @if (count($errors) > 0)						 
					        <div class="alert alert-danger">
					            <strong>Whoops!</strong> There were some problems with your input.<br><br>
					            <ul>
					                @foreach ($errors->all() as $error)
					                    <li>{{ $error }}</li>
					                @endforeach
					            </ul>
					        </div>
					    @endif
							<div class="form-group">
								<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('name',trans('user.name'),array('class'=>'control-label'))}}	
								</div>
									<div class="col-md-9">
										{{ Form::text('name',$user->name,array('class'=>'form-control','placeholder'=>trans('user.name'))) }}			
									</div>
								</div>								
							</div>
							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('login_name',trans('user.login_name'),array('class'=>'control-label'))}}
								</div>
									<div class="col-md-9">
										{{ Form::text('login_name',$user->login_name,['class'=>'form-control','placeholder'=>trans('user.login_name'),'readonly']) }}
									</div>
							</div>
							</div>
							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('user_type_id',trans('user.type'),array('class'=>'control-label'))}}
								</div>
								<div class="col-md-9">
								{{ Form::select('user_type_id',$ut,$user->user_type_id,['class'=>'form-control']) }}
								</div>
								</div>
							</div>
							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('nrc',trans('user.nrc'),array('class'=>'control-label'))}}
								</div>
									<div class="col-md-9" name="nrc">										
										<div class="row">
											<div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
											{{Form::select('state_code',[1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,13=>13,14=>14],$user->state_code,['class'=>'form-control'])}}
											</div>
											<div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
											    <div class="input-group">
											     <span class="input-group-btn">
											        <button class="btn btn-secondary" type="button"> / </button>
											      </span>											      
											      {{Form::text('city_code',$user->city_code,['class'=>'form-control','placeholder'=>trans('user.city_code')])}}
											    </div>
											</div>
											<div class="col-md-5  col-lg-5 col-sm-5 col-xs-5">
											    <div class="input-group">
											     <span class="input-group-btn">
											        <button class="btn btn-secondary" type="button"> (N) </button>
											      </span>											      
											      {{Form::text('nrc_number',$user->nrc_number,['class'=>'form-control','placeholder'=>trans('user.nrc_number')])}}
											    </div>
											</div>
										</div>										
									</div>
							</div>
							</div>
							 
							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('email',trans('user.email'),array('class'=>'control-label'))}}
								</div>
								<div class="col-md-9">
								{{ Form::email('email',$user->email,array('class'=>'form-control','placeholder'=>trans('user.email'))) }}
								</div>
								</div>
							</div>

							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('phone',trans('user.phone'),array('class'=>'control-label'))}}
								</div>
								<div class="col-md-9">
								{{ Form::text('phone',$user->phone,array('class'=>'form-control','placeholder'=>trans('user.phone'))) }}
								</div>
								</div>
							</div>
							
							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('address',trans('user.address'),array('class'=>'control-label'))}}
								</div>
								<div class="col-md-9">
								{{ Form::textarea('address',$user->address,['class'=>'form-control','size'=>'30x2']) }}
								</div>
								</div>
							</div>
							<div class="form-group">
							<div class="row">								
								<div class="col-md-9 col-md-offset-3">
									{{Form::submit(trans('form.update'),['class'=>'btn btn-primary'])}}									
								</div>
							</div>								
							</div>
						</div>
						{!! Form::close() !!}				
						{!! Form::open(['route'=>'user.profile.change_password','method'=>'POST','id'=>'password_update_form']) !!}
						<div class="col-md-5">
							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('current_password',trans('user.current_password'),array('class'=>'control-label'))}}
								</div>
								<div class="col-md-9">
									{{ Form::password('current_password',['class'=>'form-control','placeholder'=>trans('user.current_password')]) }}
								</div>
							</div>
							</div>

							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('new_password',trans('user.new_password'),array('class'=>'control-label'))}}
								</div>
								<div class="col-md-9">
									{{ Form::password('new_password',['class'=>'form-control','placeholder'=>trans('user.new_password')]) }}
								</div>
							</div>
							</div>

							<div class="form-group">
							<div class="row">
								<div class="col-md-3 align_center_right">
								{{ Form::label('confirm_password',trans('user.confirm_password'),array('class'=>'control-label')) }}
								</div>
								<div class="col-md-9">
									{{ Form::password('confirm_password',['class'=>'form-control','placeholder'=>trans('user.confirm_password')]) }}
								</div>
							</div>
							</div>
							<div class="row">
								<div class="col-md-3 align_center_right">								
								</div>
								<div class="col-md-9">
									{{Form::submit(trans('form.change'),['class'=>'btn btn-info'])}}
								</div>
							</div>
						</div>	
						{!! Form::close() !!}
					</div>
				</div>			
		</div>
	</div>
@endsection

@section('footer_scripts')
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
 {!! JsValidator::formRequest('PowerMs\Http\Requests\UserUpdateRequest', '#user_update_form'); !!}
 {!! JsValidator::formRequest('PowerMs\Http\Requests\PasswordUpdateRequest','#password_update_form'); !!}
 
@endsection
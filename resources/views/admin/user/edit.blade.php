@extends('layouts.app')

@section('contentheader_title')	
	{{ trans('user.user') }}
@endsection
@section('breadcumb')
		<li><a href="{{route('user.index')}}">{{ trans('user.user') }}</a></li> 
		<li class="active">{{ trans('form.edit') }}</li>     
@endsection

@section('content')
	<div class="container-fluid full-screen" ng-app="" ng-init="is_user=2">
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


				 @include('vendor.toast.messages')
				 <?php Session::forget('toasts'); ?>	

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
								<label><input type="radio" name="user_type_id" value="2" ng-model="is_user" @if($user->user_type_id==2) ng-checked="true" @endif> Admin </label>
								&nbsp;&nbsp;
								<label><input type="radio" name="user_type_id" value="3" ng-model="is_user"  @if($user->user_type_id==3 || old('user_type_id')==3) ng-checked="true" ng-init="is_user=3" @endif> User </label>
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
						</div>

						<div class="col-md-5" ng-show="is_user==3">
							<h4 class="text-center">{{trans('user.allowed_device')}}</h4>
					            <div class="well">
					                <ul class="list-group" name="device_list">
					                @foreach($devices as $key=>$value)					                 
									   <li class="list-group-item"><label for="{{$key}}" class="control-label"><input type="checkbox" id={{$key}} name="device_{{$key}}" @if(array_search($key,$allowed_device_ids)>-1) checked="true" @endif>&nbsp; {{$value}}</label></li>
									@endforeach
									</ul>
					            </div>
						</div>	
						<div class="form-group">
							<div class="col-md-7">
								<div class="row">
								<div class="col-md-9 col-md-offset-3">
									{{Form::submit(trans('form.update'),['class'=>'btn btn-primary'])}}	
									<button type="button" class="btn btn-info" data-toggle='modal' data-target="#update_{{$user['id']}}" ></span> {{trans('form.changepw')}}</button>	
								</div>
								</div>	
								</div>							
							</div>							
					{!! Form::close() !!}
					@include('layouts.update',['id'=>$user['id'],'route'=>'user.profile.update_password'])				
					</div>
				</div>			
		</div>
	</div>
@endsection

@section('footer_scripts')
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
 {!! JsValidator::formRequest('PowerMs\Http\Requests\UserUpdateRequest', '#user_update_form'); !!}
@endsection
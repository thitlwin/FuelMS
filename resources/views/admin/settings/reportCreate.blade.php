@extends('layouts.app')

@section('contentheader_title')	

	{{ trans('setting.report_setting')}}
@endsection

@section('breadcumb')
		<li class="active">{{ trans('setting.report_setting') }}</li>
@endsection

@section('content')
<div class="container-fluid full-screen">
		{!! Form::open(['route'=>'report_setting.save','method'=>'POST','id'=>'setting_create_form']) !!}
					{!! Form::hidden('id',$setting_id) !!}
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>
				
		 		
					
				<div class="panel panel-default">
					<div class="panel-body" >
					
						<div class="form-group">
							<div class="row">
							<div class="col-md-2" style="font-size:18px;color:green;" >	{{ ' Current ' }}</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="A" name="1"  {{array_has($dev,"A") ? "checked" : "" }}>{{' A'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="A1" name="2"{{array_has($dev,"A1") ? "checked" : "" }} >
								{{ ' A1'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="A2" name="3" {{array_has($dev,"A2") ? "checked" : "" }}>
								{{ ' A2'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="A3" name="4" {{array_has($dev,"A3") ? "checked" : "" }}>
								{{ ' A3'}}</label>
								</div>
							</div>
							</div>
				</div>
				</div>
			
					
				<div class="panel panel-default">		
					<div class="panel-body">

						<div class="form-group">
							<div class="row">
							<div class="col-md-2" style="font-size: 18px;color:green;">{{ ' Power Factor' }}
					       </div>
								<div class="col-md-2" >						
								 <label style="font-size: 16px;"><input type="checkbox" value="PF" name="24"  {{array_has($dev,"PF") ? "checked" : ""}}>
								{{ ' PF'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="PF1" name="25"  {{array_has($dev,"PF1") ? "checked" : ""}}>
								{{ ' PF1'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="PF2" name="26"  {{array_has($dev,"P2F") ? "checked" : ""}} >
								{{ ' PF2'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="PF3" name="27"  {{array_has($dev,"PF3") ? "checked" : ""}}>
								{{ 'PF3'}}</label>
								</div>
							</div>
							</div>
				</div>
				</div>

	<div class="panel panel-default">
					<div class="panel-body" >
					
						<div class="form-group">
							<div class="row">
							<div class="col-md-2" style="font-size: 18px;color:green;">
							{{'Voltage'}}
							</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VLL" name="4" {{array_has($dev,"VLL") ? "checked" : ""}}>
								{{ ' VLL'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VLN" name="5" {{array_has($dev,"VLN") ? "checked" : ""}}>
								{{ ' VLN'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V12" name="6" {{array_has($dev,"V12") ? "checked" : ""}}>
								{{ ' V12'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V23" name="7"  {{array_has($dev,"V23") ? "checked" : ""}}>
								{{ ' V23'}}</label>
								</div>
								</div>
								<div class="row" >
								<div class="col-md-2"></div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V31" name="8" {{array_has($dev,"V31") ? "checked" : ""}}>
								{{ ' V31'}}</label>
								</div>

								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V1" name="9"  {{array_has($dev,"V1") ? "checked" : ""}}>
								{{ ' V1'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V2" name="10" {{array_has($dev,"V2") ? "checked" : ""}}>
								{{ ' V2'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V3" name="11" {{array_has($dev,"V3") ? "checked" : ""}}>
								{{ ' V3'}}</label>
								</div>
								</div>
							
							</div>
							</div>
					</div>	

		<div class="panel panel-default">
					<div class="panel-body" >
					
						<div class="form-group">
							<div class="row">
							<div class="col-md-2" style="font-size: 18px;color:green;">
							{{'Power'}}
							</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="W" name="12" {{array_has($dev,"W") ? "checked" : ""}}>
								{{ ' W'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="W1" name="13"{{array_has($dev,"W1") ? "checked" : ""}}>
								{{ ' W1'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="W2" name="14" {{array_has($dev,"W2") ? "checked" : ""}}>
								{{ ' W2'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="W3" name="15" {{array_has($dev,"W3") ? "checked" : ""}}>
								{{ ' W3'}}</label>
								</div>
								</div>
								<div class="row">
								<div class="col-md-2"></div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VAR" name="16" {{array_has($dev,"VAR") ? "checked" : ""}}>
								{{ ' VAR'}}</label>
								</div>

								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VAR1"  name="17" {{array_has($dev,"VAR1") ? "checked" : ""}}>
								{{ ' VAR1'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VAR2"  name="18" {{array_has($dev,"VAR2") ? "checked" : ""}}>
								{{ ' VAR2'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VAR3"  name="19" {{array_has($dev,"VAR3") ? "checked" : ""}}>
								{{ 'VAR3'}}</label>
								</div>
								</div>
								<div class="row" >
							     <div class="col-md-2"></div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VA"  name="20" {{array_has($dev,"VA") ? "checked" : ""}}>
								{{ ' VA'}}</label>
								</div>

								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VA1" name="21"  {{array_has($dev,"VA1") ? "checked" : ""}}>
								{{ ' VA1'}}</label>
								</div>
								
							
							
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VA2" name="22"  {{array_has($dev,"VA2") ? "checked" : ""}}>
								{{ ' VA2'}}</label>
								</div>

								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VA3" name="23"  {{array_has($dev,"VA3") ? "checked" : ""}}>
								{{ ' VA3'}}</label>
								</div>
								</div>
							
							</div>
							</div>
					</div>	
			


     <div class="panel panel-default">
					<div class="panel-body" >
					
						<div class="form-group">
							
							<div class="row">
							<div class="col-md-2" style="font-size: 18px;color:green;">
							{{'Energy'}}
							</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="FVAh" name="29" {{array_has($dev,"FVAh") ? "checked" : ""}}>
								{{ ' FVAh'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="FWh" name="30" {{array_has($dev,"FWh") ? "checked" : ""}}>
								{{ ' FWh'}}</label>
								</div>

								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="FVARh" name="31" {{array_has($dev,"FVARh") ? "checked" : ""}}>
								{{ ' FVARh'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RVAh" name="32" {{array_has($dev,"RVAh") ? "checked" : ""}}>
								{{ ' RVAh'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RWh" name="33" {array_has($dev,"RWh") ? "checked" : ""}}>
								{{ ' RWh'}}</label>
								</div>
                                </div>
								<div class="row">
								<div class="col-md-2"></div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RVARh" name="34" {{array_has($dev,"RVARh") ? "checked" : ""}}>
								{{ 'RVARh'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="onH" name="35" {{array_has($dev,"onH") ? "checked" : ""}}>
								{{ ' onH'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="FRun" name="36" {{array_has($dev,"FRun") ? "checked" : ""}}>
								{{ ' FRun'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RRun" name="37" {{array_has($dev,"RRun") ? "checked" : ""}}>
								{{ ' RRun'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="INTR" name="38" {{array_has($dev,"INTR") ? "checked" : ""}}>
								{{ ' INTR'}}</label>
								</div>
							</div>
							</div>
							</div>
					</div>

					<div class="panel panel-default">
					<div class="panel-body" >
					
						<div class="form-group">
							<div class="row">

							<div class="col-md-2" style="font-size: 18px;color:green;">
							{{'Miscellaneous'}}
							</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="PD" name="39" {{array_has($dev,"PD") ? "checked" : ""}}>
								{{ ' PD (Present Demand)'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RD" name="40" {{array_has($dev,"RD") ? "checked" : ""}}>
								{{ ' RD (Rising Demand)'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="MaxMD" name="41" {{array_has($dev,"MaxMD") ? "checked" : ""}}>
								{{ ' MaxMD'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="MaxDM" name="42" {{array_has($dev,"MaxDM") ? "checked" : ""}}>
								{{ ' MaxDM'}}</label>
								</div>
								<div class="col-md-2">
								<label style="font-size: 16px;"><input type="checkbox" value="F" name="28"  {{array_has($dev,"F") ? "checked" : ""}}>
								{{ ' F (Frequency)'}}</label>
								</div>
							</div>
							</div>
							</div>
					</div>

       <div class="form-group">
							<div class="row" style="margin-left:400px;">								
								{{Form::submit(trans('form.update'),['class'=>'btn btn-primary'])}}
									{{Form::reset(trans('form.reset'),['class'=>'btn btn-warning'])}}
							</div>								
		</div>
							{!! Form::close() !!}	
   
</div>
				
	@endsection

@section('footer_scripts')
 <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
 {!! JsValidator::formRequest('PowerMs\Http\Requests\SettingRequest', '#setting_create_form'); !!}
@endsection

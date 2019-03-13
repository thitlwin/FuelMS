@extends('layouts.app')

@section('contentheader_title')	

	{{ trans('report.excel_export')}}
@endsection

@section('breadcumb')
		<li class="active">{{ trans('report.excel_export') }}</li>
@endsection

@section('content')
<div class="container-fluid full-screen">
		{!! Form::open(['route'=>'post.excel_export','method'=>'POST','id'=>'setting_create_form']) !!}					
					@include('vendor.toast.messages')
					<?php Session::forget('toasts'); ?>
					
				<div class="panel panel-default">
					<div class="panel-body" >
						<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<div class="form-inline">
									{{Form::label('device_id',trans('report.device'),['class'=>'control-label'])}}
				                    {{Form::select('device_id',$devices,$selected_device_id,['class'=>'form-control'])}}
				                    &nbsp;&nbsp;&nbsp;

									{{Form::label('date',trans('report.start_date'),['class'=>'control-label'])}}
				                    <div class='input-group date' id='start_time_picker'>
				                        <input name="start_date" id="start_time" type='text' class="form-control" readonly value="{{$start_date}}" />
				                        <span class="input-group-addon">
				                            <span class="glyphicon glyphicon-calendar">
				                            </span>
				                        </span>
				                    </div>
				                    {{Form::label('date',trans('report.end_date'),['class'=>'control-label'])}}
				                    <div class='input-group date' id='end_time_picker'>
				                        <input name="end_date" id="end_time" type='text' class="form-control" readonly value="{{$end_date}}" />
				                        <span class="input-group-addon">
				                            <span class="glyphicon glyphicon-calendar">
				                            </span>
				                        </span>
				                    </div>	
								</div>
							</div>							
						</div>
						<p/>
						<div class="row">
							<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading"><b>{{trans('report.select_column')}}</b></div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-4">
												<div class="panel panel-default">
												<div class="panel-heading">Current</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-md-3" >						
														<label style="font-size: 16px;"><input type="checkbox" value="A" name="checked_columns[]"  {{array_has($export_column_pref,"A") ? "checked" : "" }}>{{' A'}}</label>
														</div>
														<div class="col-md-3" >						
														<label style="font-size: 16px;"><input type="checkbox" value="A1" name="checked_columns[]"{{array_has($export_column_pref,"A1") ? "checked" : "" }} >
														{{ ' A1'}}</label>
														</div>
														<div class="col-md-3" >						
														<label style="font-size: 16px;"><input type="checkbox" value="A2" name="checked_columns[]" {{array_has($export_column_pref,"A2") ? "checked" : "" }}>
														{{ ' A2'}}</label>
														</div>
														<div class="col-md-3" >						
														<label style="font-size: 16px;"><input type="checkbox" value="A3" name="checked_columns[]" {{array_has($export_column_pref,"A3") ? "checked" : "" }}>
														{{ ' A3'}}</label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
												<div class="panel panel-warning">
												<div class="panel-heading">Power Factor</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-md-3" >						
														 <label style="font-size: 16px;"><input type="checkbox" value="PF" name="checked_columns[]"  {{array_has($export_column_pref,"PF") ? "checked" : ""}}>
														{{ ' PF'}}</label>
														</div>
														<div class="col-md-3" >						
														<label style="font-size: 16px;"><input type="checkbox" value="PF1" name="checked_columns[]"  {{array_has($export_column_pref,"PF1") ? "checked" : ""}}>
														{{ ' PF1'}}</label>
														</div>
														<div class="col-md-3" >						
														<label style="font-size: 16px;"><input type="checkbox" value="PF2" name="checked_columns[]"  {{array_has($export_column_pref,"P2F") ? "checked" : ""}} >
														{{ ' PF2'}}</label>
														</div>
														<div class="col-md-3" >						
														<label style="font-size: 16px;"><input type="checkbox" value="PF3" name="checked_columns[]"  {{array_has($export_column_pref,"PF3") ? "checked" : ""}}>
														{{ 'PF3'}}</label>
														</div>
													</div>
												</div>
											</div>
										</div>
											<div class="col-md-4">
												<div class="panel panel-info">
												<div class="panel-heading">Voltage</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VLL" name="checked_columns[]" {{array_has($export_column_pref,"VLL") ? "checked" : ""}}>
								{{ ' VLL'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VLN" name="checked_columns[]" {{array_has($export_column_pref,"VLN") ? "checked" : ""}}>
								{{ ' VLN'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V12" name="checked_columns[]" {{array_has($export_column_pref,"V12") ? "checked" : ""}}>
								{{ ' V12'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V23" name="checked_columns[]"  {{array_has($export_column_pref,"V23") ? "checked" : ""}}>
								{{ ' V23'}}</label>
								</div>								
													</div>
													<div class="row">
														<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V31" name="checked_columns[]" {{array_has($export_column_pref,"V31") ? "checked" : ""}}>
								{{ ' V31'}}</label>
								</div>

								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V1" name="checked_columns[]"  {{array_has($export_column_pref,"V1") ? "checked" : ""}}>
								{{ ' V1'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V2" name="checked_columns[]" {{array_has($export_column_pref,"V2") ? "checked" : ""}}>
								{{ ' V2'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="V3" name="checked_columns[]" {{array_has($export_column_pref,"V3") ? "checked" : ""}}>
								{{ ' V3'}}</label>
								</div>
													</div>
												</div>
											</div>
										</div>
</div>
								<div class="row">
											<div class="col-md-4">
												<div class="panel panel-default">
												<div class="panel-heading">Power</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="W" name="checked_columns[]" {{array_has($export_column_pref,"W") ? "checked" : ""}}>
								{{ ' W'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="W1" name="checked_columns[]"{{array_has($export_column_pref,"W1") ? "checked" : ""}}>
								{{ ' W1'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="W2" name="checked_columns[]" {{array_has($export_column_pref,"W2") ? "checked" : ""}}>
								{{ ' W2'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="W3" name="checked_columns[]" {{array_has($export_column_pref,"W3") ? "checked" : ""}}>
								{{ ' W3'}}</label>
								</div>
													</div>
													<div class="row">								
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VAR" name="checked_columns[]" {{array_has($export_column_pref,"VAR") ? "checked" : ""}}>
								{{ ' VAR'}}</label>
								</div>

								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VAR1"  name="checked_columns[]" {{array_has($export_column_pref,"VAR1") ? "checked" : ""}}>
								{{ ' VAR1'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VAR2"  name="checked_columns[]" {{array_has($export_column_pref,"VAR2") ? "checked" : ""}}>
								{{ ' VAR2'}}</label>
								</div>
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VAR3"  name="checked_columns[]" {{array_has($export_column_pref,"VAR3") ? "checked" : ""}}>
								{{ 'VAR3'}}</label>
								</div>
								</div>
								<div class="row" >
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VA"  name="checked_columns[]" {{array_has($export_column_pref,"VA") ? "checked" : ""}}>
								{{ ' VA'}}</label>
								</div>

								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VA1" name="checked_columns[]"  {{array_has($export_column_pref,"VA1") ? "checked" : ""}}>
								{{ ' VA1'}}</label>
								</div>
								
							
							
								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VA2" name="checked_columns[]"  {{array_has($export_column_pref,"VA2") ? "checked" : ""}}>
								{{ ' VA2'}}</label>
								</div>

								<div class="col-md-3" >						
								<label style="font-size: 16px;"><input type="checkbox" value="VA3" name="checked_columns[]"  {{array_has($export_column_pref,"VA3") ? "checked" : ""}}>
								{{ ' VA3'}}</label>
								</div>
								</div>
												</div>
											</div>
											</div>
											<div class="col-md-4">
												<div class="panel panel-warning">
												<div class="panel-heading">Energy</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="FVAh" name="checked_columns[]" {{array_has($export_column_pref,"FVAh") ? "checked" : ""}}>
								{{ ' FVAh'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="FWh" name="checked_columns[]" {{array_has($export_column_pref,"FWh") ? "checked" : ""}}>
								{{ ' FWh'}}</label>
								</div>

								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="FVARh" name="checked_columns[]" {{array_has($export_column_pref,"FVARh") ? "checked" : ""}}>
								{{ ' FVARh'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RVAh" name="checked_columns[]" {{array_has($export_column_pref,"RVAh") ? "checked" : ""}}>
								{{ ' RVAh'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RWh" name="checked_columns[]" {array_has($export_column_pref,"RWh") ? "checked" : ""}}>
								{{ ' RWh'}}</label>
								</div>
													</div>
													<div class="row">
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RVARh" name="checked_columns[]" {{array_has($export_column_pref,"RVARh") ? "checked" : ""}}>
								{{ 'RVARh'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="onH" name="checked_columns[]" {{array_has($export_column_pref,"onH") ? "checked" : ""}}>
								{{ ' onH'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="FRun" name="checked_columns[]" {{array_has($export_column_pref,"FRun") ? "checked" : ""}}>
								{{ ' FRun'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RRun" name="checked_columns[]" {{array_has($export_column_pref,"RRun") ? "checked" : ""}}>
								{{ ' RRun'}}</label>
								</div>
								<div class="col-md-2" >						
								<label style="font-size: 16px;"><input type="checkbox" value="INTR" name="checked_columns[]" {{array_has($export_column_pref,"INTR") ? "checked" : ""}}>
								{{ ' INTR'}}</label>
								</div>
							</div>

												</div>
											</div>
											</div>
											<div class="col-md-4">
												<div class="panel panel-info">
												<div class="panel-heading">Miscellaneous</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-md-12" >						
								<label style="font-size: 16px;"><input type="checkbox" value="PD" name="checked_columns[]" {{array_has($export_column_pref,"PD") ? "checked" : ""}}>
								{{ ' PD (Present Demand)'}}</label>
								</div>
								<div class="col-md-12" >						
								<label style="font-size: 16px;"><input type="checkbox" value="RD" name="checked_columns[]" {{array_has($export_column_pref,"RD") ? "checked" : ""}}>
								{{ ' RD (Rising Demand)'}}</label>
								</div>
								<div class="col-md-6" >						
								<label style="font-size: 16px;"><input type="checkbox" value="MaxMD" name="checked_columns[]" {{array_has($export_column_pref,"MaxMD") ? "checked" : ""}}>
								{{ ' MaxMD'}}</label>
								</div>
								<div class="col-md-6" >						
								<label style="font-size: 16px;"><input type="checkbox" value="MaxDM" name="checked_columns[]" {{array_has($export_column_pref,"MaxDM") ? "checked" : ""}}>
								{{ ' MaxDM'}}</label>
								</div>
								<div class="col-md-6">
								<label style="font-size: 16px;"><input type="checkbox" value="F" name="checked_columns[]"  {{array_has($export_column_pref,"F") ? "checked" : ""}}>
								{{ ' F (Frequency)'}}</label>
								</div>
													</div>
												</div>
											</div>
										</div>

										</div>
									</div>
								</div>
							</div>

							</div>
						</div>
  
							<div class="row">
							<div class="col-md-4">								
								<button type="submit" class="btn btn-primary">
						          <span class="glyphicon glyphicon-export"></span> {{trans('form.export_excel')}}
						        </button>
								{{Form::reset(trans('form.reset'),['class'=>'btn btn-warning'])}}
							</div>	
							</div>

						</div>
					</div>
				</div> 
 
  
							{!! Form::close() !!}	
   
</div>
				
	@endsection

@section('footer_scripts')
  @include('script_datetime_picker')  
  <script type="text/javascript">
    $(function () {
        $('#start_time_picker').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
                format: 'dd-mm-yyyy',
                    });

             $('#end_time_picker').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
                format: 'dd-mm-yyyy',
                    });

             $('#start_time_picker').datetimepicker().on('changeDate',function(ev){
              var yr=$('#start_time').val();
              console.log('start_time='+yr);
              $('#end_time_picker').datetimepicker('setStartDate',yr);
             });

              $('#end_time_picker').datetimepicker().on('changeDate',function(ev){
              var yr=$('#end_time').val();
              console.log('end_time='+yr);
              $('#start_time_picker').datetimepicker('setEndDate',yr);
             });
        });
  </script>
@endsection

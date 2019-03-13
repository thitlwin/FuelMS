@extends('layouts.app')

@section('contentheader')

  @section('contentheader_title') 
      
  @endsection 
@endsection
@section('breadcumb')
      <li class="active">{{ trans('report.timely_electrical_report') }}</li> 
@endsection

@section('content')
  <div class="container-fluid full-screen">
    <div class="row">
      <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          {{Form::open(['route'=>'electrical_report_by_time','method'=>'get','class'=>'form-inline'])}}
                 <div class="form-group">
                    {{Form::label('device_id',trans('report.device'),['class'=>'control-label'])}}
                    {{Form::select('device_id',$devices,$selected_device_id,['class'=>'form-control'])}}
                    &nbsp;&nbsp;&nbsp;
                  </div>
                  <div class="form-group">
                    {{Form::label('date',trans('report.start_time'),['class'=>'control-label'])}}
                    <div class='input-group date' id='start_time_picker'>
                        <input name="start_time" id="start_time" type='text' class="form-control" readonly value="{{$start_time}}" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                  </div>
                   <div class="form-group">
                    {{Form::label('date',trans('report.end_time'),['class'=>'control-label'])}}
                    <div class='input-group date' id='end_time_picker'>
                        <input name="end_time" id="end_time" type='text' class="form-control" readonly value="{{$end_time}}" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                  </div>
                   
                  {{Form::submit(trans('form.search'),['class'=>'btn btn-primary'])}}
          {{Form::close()}}
        </div>  
      </div>
    </div>
    </div>
    @if($date_has_error)
    @include('vendor.toast.messages')
    <?php Session::forget('toasts'); ?> 
    @else
    @if($is_user_selected_column==false)
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-danger">
            <div class="panel-heading">
              {{trans('report.empty_selected_columns')}} <a href="{{route('report_setting.create')}}" class="btn btn-xs btn-info">{{trans('report.select_report_column')}}</a>
            </div>
          </div>
        </div>
      </div>
    @endif
    @if(count($energy_chart['columns'])>0)
    <div class="row">         
    <div class="col-md-12" id="energy_chart_div" style="min-height: 500px;"></div><br/>
    </div>  
    <br/><br/> 
    @endif
    @if(count($current_chart['columns'])>0)
    <div class="row">
      <div class="col-md-12" id="current_chart_div" style="min-height: 500px;"></div>
    </div> 
    <br/><br/> 
    @endif
    @if(count($power_chart['columns'])>0)
    <div class="row">
      <div class="col-md-12" id="power_chart_div" style="min-height: 500px;"></div><br/><br/> 
  </div> <br/><br/> 
    @endif
    @if(count($power_factor_chart['columns'])>0)
    <div class="row">         
    <div class="col-md-12" id="power_factor_chart_div" style="min-height: 500px;"></div><br/>
    </div>  
    <br/><br/> 
    @endif
    @if(count($voltage_chart['columns'])>0)
    <div class="row">
      <div class="col-md-12" id="voltage_chart_div" style="min-height: 500px;"></div>
    </div> 
    <br/><br/> 
    @endif
    @if(count($miscellaneous_chart['columns'])>0)
    <div class="row">
      <div class="col-md-12" id="miscellaneous_chart_div" style="min-height: 500px;"></div><br/><br/> 
    </div>   
    @endif  
    <script type="text/javascript">
      var energy_chart={!! json_encode($energy_chart); !!};
      var current_chart={!! json_encode($current_chart); !!};
      var power_chart={!! json_encode($power_chart) !!};
      var power_factor_chart={!! json_encode($power_factor_chart); !!};
      var voltage_chart={!! json_encode($voltage_chart); !!};
      var miscellaneous_chart={!! json_encode($miscellaneous_chart); !!};
    </script>
    @endif
@endsection

@section('footer_scripts')
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.charts.load('visualization',"1", {'packages':['corechart','line']});
      if(energy_chart.columns.length>0)
        google.charts.setOnLoadCallback(drawEnergyChart);
      if(current_chart.columns.length>0)
        google.charts.setOnLoadCallback(drawCurrentChart);
      if(power_chart.columns.length>0)
        google.charts.setOnLoadCallback(drawPowerChart);
      if(power_factor_chart.columns.length>0)
        google.charts.setOnLoadCallback(drawPowerFactorChart);
      if(voltage_chart.columns.length>0)
        google.charts.setOnLoadCallback(drawVoltageChart);
      if(miscellaneous_chart.columns.length>0)
        google.charts.setOnLoadCallback(drawMiscellaneousChart);
      

      function drawEnergyChart() {        
        var chart_columns=energy_chart.columns;
        var chart_rows=energy_chart.rows;
        var data=new google.visualization.DataTable();        
        data.addColumn('string','Time');        
        for (var i = 0; i < chart_columns.length; i++) {
          data.addColumn('number',chart_columns[i]);          
        }

        var rows=[];
        for (var i = 0; i < chart_rows.length; i++) {
          var data_row=Object.values(chart_rows[i]);          
          rows.push(Array.from(data_row));
        }        
        data.addRows(rows);
        var options = {
          title: energy_chart.title,  
          curveType: 'function',       
          hAxis: {
            title: 'Time',
            logScale: false
          },
          vAxis:{
            title: 'Electrial Usage',
            scaleType: 'mirrorLog'
          }
        };
      var chart = new google.visualization.LineChart(document.getElementById('energy_chart_div'));
      chart.draw(data, options);
      }

       function drawCurrentChart() {        
        var chart_columns=current_chart.columns;
        var chart_rows=current_chart.rows;
        var data=new google.visualization.DataTable();        
        data.addColumn('string','Time');        
        for (var i = 0; i < chart_columns.length; i++) {
          data.addColumn('number',chart_columns[i]);          
        }

        var rows=[];
        for (var i = 0; i < chart_rows.length; i++) {
          var data_row=Object.values(chart_rows[i]);          
          rows.push(Array.from(data_row));
        }        
        data.addRows(rows);
        var options = {
          title: current_chart.title,  
          curveType: 'function',       
          hAxis: {
            title: 'Time',
            logScale: false
          },
          vAxis:{
            title: 'Electrial Usage',
            scaleType: 'mirrorLog'
          }
        };
      var chart = new google.visualization.LineChart(document.getElementById('current_chart_div'));
      chart.draw(data, options);
      }

       function drawPowerChart() {        
        var chart_columns=power_chart.columns;
        var chart_rows=power_chart.rows;
        var data=new google.visualization.DataTable();        
        data.addColumn('string','Time');        
        for (var i = 0; i < chart_columns.length; i++) {
          data.addColumn('number',chart_columns[i]);          
        }

        var rows=[];
        for (var i = 0; i < chart_rows.length; i++) {
          var data_row=Object.values(chart_rows[i]);          
          rows.push(Array.from(data_row));
        }        
        data.addRows(rows);
        var options = {
          title: power_chart.title,  
          curveType: 'function',       
          hAxis: {
            title: 'Time',
            logScale: false
          },
          vAxis:{
            title: 'Electrial Usage',
            scaleType: 'mirrorLog'
          }
        };
      var chart = new google.visualization.LineChart(document.getElementById('power_chart_div'));
      chart.draw(data, options);
      }

       function drawPowerFactorChart() {        
        var chart_columns=power_factor_chart.columns;
        var chart_rows=power_factor_chart.rows;
        var data=new google.visualization.DataTable();        
        data.addColumn('string','Time');        
        for (var i = 0; i < chart_columns.length; i++) {
          data.addColumn('number',chart_columns[i]);          
        }

        var rows=[];
        for (var i = 0; i < chart_rows.length; i++) {
          var data_row=Object.values(chart_rows[i]);          
          rows.push(Array.from(data_row));
        }        
        data.addRows(rows);
        var options = {
          title: power_factor_chart.title,  
          curveType: 'function',       
          hAxis: {
            title: 'Time',
            logScale: false
          },
          vAxis:{
            title: 'Electrial Usage',
            scaleType: 'mirrorLog'
          }
        };
      var chart = new google.visualization.LineChart(document.getElementById('power_factor_chart_div'));
      chart.draw(data, options);
      }

       function drawVoltageChart() {        
        var chart_columns=voltage_chart.columns;
        var chart_rows=voltage_chart.rows;
        var data=new google.visualization.DataTable();        
        data.addColumn('string','Time');        
        for (var i = 0; i < chart_columns.length; i++) {
          data.addColumn('number',chart_columns[i]);          
        }

        var rows=[];
        for (var i = 0; i < chart_rows.length; i++) {
          var data_row=Object.values(chart_rows[i]);          
          rows.push(Array.from(data_row));
        }        
        data.addRows(rows);
        var options = {
          title: voltage_chart.title,  
          curveType: 'function',       
          hAxis: {
            title: 'Time',
            logScale: false
          },
          vAxis:{
            title: 'Electrial Usage',
            scaleType: 'mirrorLog'
          }
        };
        var chart = new google.visualization.LineChart(document.getElementById('voltage_chart_div'));
        chart.draw(data, options);
      }

       function drawMiscellaneousChart() {        
        var chart_columns=miscellaneous_chart.columns;
        var chart_rows=miscellaneous_chart.rows;
        var data=new google.visualization.DataTable();        
        data.addColumn('string','Time');        
        for (var i = 0; i < chart_columns.length; i++) {
          data.addColumn('number',chart_columns[i]);          
        }

        var rows=[];
        for (var i = 0; i < chart_rows.length; i++) {
          var data_row=Object.values(chart_rows[i]);          
          rows.push(Array.from(data_row));
        }        
        data.addRows(rows);
        var options = {
          title: miscellaneous_chart.title,  
          curveType: 'function',       
          hAxis: {
            title: 'Time',
            logScale: false
          },
          vAxis:{
            title: 'Electrial Usage',
            scaleType: 'mirrorLog'
          }
        };
      var chart = new google.visualization.LineChart(document.getElementById('miscellaneous_chart_div'));
      chart.draw(data, options);
      }
    $(window).resize(function(){
      if(energy_chart.columns.length>0)
        drawEnergyChart();
      if(current_chart.columns.length>0)
        drawCurrentChart();
      if(power_chart.columns.length>0)
        drawPowerChart();
      if(power_factor_chart.columns.length>0)
        drawPowerFactorChart();
      if(voltage_chart.columns.length>0)
        drawVoltageChart();
      if(miscellaneous_chart.columns.length>0)
        drawMiscellaneousChart();
    });
    </script>

  @include('script_datetime_picker')  
  <script type="text/javascript">
    $(function () {
        $('#start_time_picker').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 0,
                minView: 0,
                forceParse: 0,
                format: 'dd-mm-yyyy HH:ii P',
                showMeridian: true
                    });

             $('#end_time_picker').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 0,
                minView: 0,
                forceParse: 0,
                format: 'dd-mm-yyyy HH:ii P',
                minuteStep: 5,
                showMeridian: true
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
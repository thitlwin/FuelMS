@extends('layouts.app')

@section('contentheader')

  @section('contentheader_title') 
      <h4>{{ trans('report.wh_reports')}} [{{trans('report.daily_fwh_report')}}]</h4>      
  @endsection 
@endsection
@section('breadcumb')
      <li>{{ trans('report.wh_reports') }}</li> 
      <li class="active">{{ trans('report.daily_fwh_report') }}</li> 
@endsection

@section('content')
  <div class="container-fluid full-screen" ng-app="myApp" ng-controller="myCtrl">
    <div class="row">
      <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          {{Form::open(['route'=>'wh_report_by_date_range','method'=>'get','class'=>'form-inline'])}}
           @if(Auth::user()->user_type_id==2)
                <div class="form-group">
                    {{Form::label('location_id',trans('report.location'),['class'=>'control-label'])}}                    
                    <select class="form-control" ng-model="myLocation" ng-options="loc.id as loc.name for loc in locations" ng-change="loadDevice()">
                    </select>
                    <input type="hidden" name="location_id" id="my_location_id">
                    &nbsp;&nbsp;&nbsp;
                </div>
              @endif
                 <div class="form-group">
                    {{Form::label('device_id',trans('report.device'),['class'=>'control-label'])}}
                    <select ng-model="myDevice" class="form-control" ng-options="dev.id as dev.name for dev in devices"></select>
                    <input type="hidden" name="device_id" id="my_device_id">
                    &nbsp;&nbsp;&nbsp;
                  </div>
                  <div class="form-group">
                    {{Form::label('date',trans('report.start_date'),['class'=>'control-label'])}}
                    <div class='input-group date' id='start_time_picker'>
                        <input name="start_date" id="start_time" type='text' class="form-control" readonly value="{{$start_date}}" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                  </div>
                   <div class="form-group">
                    {{Form::label('date',trans('report.end_date'),['class'=>'control-label'])}}
                    <div class='input-group date' id='end_time_picker'>
                        <input name="end_date" id="end_time" type='text' class="form-control" readonly value="{{$end_date}}" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                  </div>
              @if(Auth::user()->user_type_id==2)
                {{Form::submit(trans('form.view_report'),['class'=>'btn btn-primary','ng-click'=>'search()'])}}
              @else
                {{Form::submit(trans('form.view_report'),['class'=>'btn btn-primary','ng-click'=>'searchForUser()'])}}
              @endif
          {{Form::close()}}
        </div>  
      </div>
    </div>
    </div>
    @if($date_has_error)
      @include('vendor.toast.messages')
      <?php Session::forget('toasts'); ?> 
    @else   
    @if(is_null($chart_data))
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-danger">
            <div class="panel-heading">
              {{trans('report.empty_data')}} 
            </div>
          </div>
        </div>
      </div>
    @else
    <div class="row">      
    <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-12" id="chart_div" style="min-height: 500px;"></div><br/>                
          <center style='color: blue;'>
            <span style="color:red;">Min = {{$min_value.'h'}} ,</span> Max = {{$max_value.'h'}},
            <span style="color:red;">Avg = {{$avg.'h'}},</span> Total = {{$total_value.'h'}} 
          </center>

      </div>
    </div>   
    </div>
    </div>

    @endif
    </div>  
    <br/><br/> 
    <script type="text/javascript">
    var chart_data={!! json_encode($chart_data); !!};
    </script>
    @endif
@endsection

@section('footer_scripts')
<script type="text/javascript">
  var allDevice={!! json_encode($devices) !!};
  var selected_location={!! json_encode($selected_location) !!};
  var selected_device={!! json_encode($selected_device) !!};

  var app=angular.module('myApp',[]);
  app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('<%').endSymbol('%>');
  });

  app.controller('myCtrl',function($scope,$http) 
  {
    $scope.locations={!! json_encode($locations) !!};  
    $scope.devices=allDevice;
    $scope.myLocation=parseInt(selected_location.id);
    $scope.myDevice=parseInt(selected_device.id);
    console.log('locationId at first='+$scope.myLocation); 
    $scope.loadDevice=function(){
      if($scope.myLocation<=0){
        $scope.devices=allDevice;
        $scope.myDevice=$scope.devices[0].id;
      }else{
         $http({
        'method': 'GET',
        'url': '/api/get_device_by_location?locationId='+$scope.myLocation
        }).then(function(response) {
          // $scope.devices=[];
          $scope.devices=response.data.data;
          $scope.myDevice=$scope.devices[0].id;
        },function(response) {
          $('#errorMessage').html('Empty device at this location.');
          $('#errorModal').modal();
        });
      }     
    }

    $scope.search=function() {
      document.getElementById('my_location_id').value=$scope.myLocation;
      document.getElementById('my_device_id').value=$scope.myDevice;
      document.getElementById('search_form').submit();
    }
    $scope.searchForUser=function() {
      document.getElementById('my_device_id').value=$scope.myDevice;
      document.getElementById('search_form').submit();
    }
  });
</script>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">    
      google.charts.load('visualization',"1", {'packages':['corechart','bar']});
      google.charts.setOnLoadCallback(drawChart);

       function drawChart() {        
        var chart_rows=chart_data;
        var data=new google.visualization.DataTable();        
        data.addColumn('string','Days');        
        data.addColumn('number','Wh');        

        var rows=[];
        for (var i = 0; i < chart_rows.length; i++) {
          var data_row=Object.values(chart_rows[i]);          
          rows.push(Array.from(data_row));
        }        
        data.addRows(rows);
        var options = {
          title: '{{$title}}',  
          // curveType: 'function',  //for line smooth     
          hAxis: {
            title: 'Days',
            logScale: false
          },
          vAxis:{
            viewWindowMode: 'explicit',
            viewWindow:{
              min: 0,              
            },
            title: '{{$y_title}}',
            // scaleType: 'mirrorLog'
          }
        };
      // var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
      }
    $(window).resize(function(){
        drawChart();
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
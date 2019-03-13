@extends('layouts.app')

@section('contentheader')
  @section('contentheader_title') 
      <h4>{{ trans('report.w_report')}}</h4>      
  @endsection 
@endsection
@section('breadcumb')
      <li class="active">{{ trans('report.w_report') }}</li> 
@endsection

@section('content')
  <div class="container-fluid full-screen" ng-app="myApp" ng-controller="myCtrl">
    <div class="row">     
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          {{Form::open(['route'=>['daily_w_report',$group_by],'method'=>'get','class'=>'form-inline','id'=>'search_form'])}}
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
                    {{Form::label('date',trans('report.date'),['class'=>'control-label'])}}
                    <div class='input-group date' id='datetimepicker9'>
                        <input id="date" name="date" type='text' class="form-control" readonly value="{{$date}}" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                    </div>
                  </div> &nbsp;&nbsp;&nbsp;
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
        <div class="btn-group pull-right" role="group" aria-label="First group" style="background: yellow; padding: 1px;">
            <a type="button" href="{{route('daily_w_report','15mins?device_id='.$selected_device->id.'&date='.$date)}}" class="btn btn-xs @if($group_by=='15mins') btn-warning @else btn-primary @endif">15 Mins</a>
            <a type="button" href="{{route('daily_w_report','30mins?device_id='.$selected_device->id.'&date='.$date)}}" class="btn btn-xs @if($group_by=='30mins') btn-warning @else btn-primary @endif" style="margin: 0px 2px 0px 2px;">30 Mins</a>
            <a type="button" href="{{route('daily_w_report','hour?device_id='.$selected_device->id.'&date='.$date)}}" class="btn btn-xs @if($group_by=='hour') btn-warning @else btn-primary @endif">1 Hour</a>
        </div>
      </div>      
    </div>
    <div class="row">      
    <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">          
        <div class="col-md-12" id="chart_div" style="min-height: 500px;"></div><br/>        
        <center style="color: blue;">
          <span style="color:red;">Min = {{$min}}, </span> Max = {{$max}}, <span style="color:red"> Avg = {{$avg}}</span>
        </center>
      </div>
    </div>   
    </div>
    </div>
    @endif     

    <div class="modal fade" id="errorModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">Alert</div>
        <div class="modal-body"><p id="errorMessage"></p></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss='modal'>Close</button>
        </div>
      </div>  
    </div>        
    </div> 

  </div>
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
    console.log('location obj='+selected_location);
    console.log('locationId at first='+$scope.myLocation); 
    console.log('location Name at first='+selected_location.name);
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

<script type="text/javascript" src="{{asset('js/google_chart_resize.js')}}"></script>
<script type="text/javascript">
  var chart_data={!! $chart_data !!};
  google.charts.load('visualization',"1", {'packages':['corechart','line']});
      google.charts.setOnLoadCallback(drawChart);

       function drawChart() {
        
        /*var chart_rows=chart_data;
        var data=new google.visualization.DataTable();        
        data.addColumn('date','Time of Usage');        
        data.addColumn('number','W');        

        var rows=[];
        for (var i = 0; i < chart_rows.length; i++) {          
          var data_row=Object.values(chart_rows[i]);        
          rows.push(Array.from(data_row));
        }                
        data.addRows(rows);*/
        var data = google.visualization.arrayToDataTable(chart_data);
        var options = {
          title: '{{$title}}',            
          // curveType: 'function',       
          enableInteractivity: true,
          hAxis: {
            title: '{{$x_title}}',
            // logScale: false,
            format: '{{$time_format}}',
            gridlines: {
              count: {{$grid_count}},              
            }
          },
          vAxis:{
            title: '{{$y_title}}',
            // scaleType: 'mirrorLog'            
          }
        };
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
      }

    $(window).resize(function(){
        drawChart();
    });
</script>
  @include('script_datetime_picker')  
  <script type="text/javascript">
       $(function () {
            $('#datetimepicker9').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0,
                format: 'dd-mm-yyyy'
                    });
            });
  </script>
@endsection

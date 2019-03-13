@extends('layouts.app')

@section('contentheader_title')	
@endsection
@section('breadcumb')
      <li class="active">{{ trans('dashboard.dashboard') }} </li> 
@endsection
@section('content')
<script type="text/javascript">
.chart {
  width: 100%; 
  min-height: 450px;
}
</script>
<style>
#mySidenav a {
    position: absolute;
    right: -80px;
    transition: 0.3s;
    padding: 15px;
    width: 145px;
    text-decoration: none;
    font-size: 13px;
    color: white;
    border-radius: 5px 0 0 5px;
}

#mySidenav a:hover {
    right: 0;
}

#about {
    top: 20px;
    background-color: #4CAF50;
}

#blog {
    top: 80px;
    background-color: #2196F3;
}

#projects {
    top: 140px;
    background-color: #f44336;
}

#contact {
    top: 200px;
    background-color: #555
}
</style>
         
<div ng-app="myApp" ng-controller="myCtrl">
    <div class="container-fluid full-screen">
      <div class="row">   
        <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                  @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                      @if(Auth::user()->user_type_id ==2)
                        <div class="col-md-1">
                         {{ Form::label('device',trans('dashboard.location'),array('class'=>'control-label'))}}
                        </div>
                        <div class="col-md-2">
                         <select ng-model="selectedlocation" class="form-control" name="selectedlocation" id="selectedlocation" ng-options="locations.location_id as locations.location_name for locations in device_location" ng-change="changeLocation(selectedlocation)" required></select>                    
                        </div>
                      @endif
                       <div class="col-md-1">
                         {{ Form::label('device',trans('dashboard.device_id'),array('class'=>'control-label'))}}
                       </div>
                       <div class="col-md-2">
                         <select ng-model="selectedName" class="form-control" name="selectedName" id="selectedName" ng-options="device.device_id as device.name for device in device_name" ng-change="changePath(selectedName,{{$auth_user}})" required></select>                    
                       </div>
                    </div>
                </div>
              </div>  
            </div>
        </div>
         @else 
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row">
                  <div class="form-group">
                    @if(Auth::user()->user_type_id ==2)
                      <div class="col-md-1">
                       {{ Form::label('device',trans('dashboard.location'),array('class'=>'control-label'))}}
                      </div>
                      <div class="col-md-2">
                       <select ng-model="selectedlocation" class="form-control" name="selectedlocation" id="selectedlocation" ng-options="locations.location_id as locations.location_name for locations in device_location" ng-change="changeLocation(selectedlocation)" required></select>                    
                      </div>
                     @endif
                     <div class="col-md-1">
                       {{ Form::label('device',trans('dashboard.device_id'),array('class'=>'control-label'))}}
                     </div>
                     <div class="col-md-2">
                       <select ng-model="selectedName" class="form-control" name="selectedName" id="selectedName" ng-options="device.device_id as device.name for device in device_name" ng-change="changePath(selectedName,{{$auth_user}})" required></select>                    
                     </div>
                  </div>
              </div>
            </div>  
          </div>
        </div>
         <div ng-show="emptyData">
            <div class="col-md-12">
              <div class="panel panel-default">
                 <div class="panel-body">
                    <div class="col-md-3">
                      <div id="chart_div1" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div2" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div3" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div4" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div5" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div6" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div7" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div8" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div9" class="chart"></div>
                    </div>
                    <div class="col-md-3">
                      <div id="chart_div10" class="chart"></div>
                    </div>
                 </div>
              </div>
            </div>
         </div>
         
        <div class="modal fade" id="errorModal" role='dialog'>
            <div class="modal-dialog" STYLE="height: 150px; width: 300px;">
              <div class="modal-content">
                <div class="modal-body">
                  <p id='errorMessage'></p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss='modal'>Close</button>
                </div>
              </div>
            </div>
        </div> 
        @endif   
      </div>    
    </div>
</div>
<div ng-show="showError">
      <div class="row">
            <div class="col-md-12">
              <div class="panel panel-danger">
                <div class="panel-heading">
                  {{trans('report.empty_data')}} 
                </div>
              </div>
            </div>
      </div>
</div>
@endsection

@section('footer_scripts')

<script type="text/javascript">

  var app=angular.module('myApp',[]);
	app.config(function($interpolateProvider){
	$interpolateProvider.startSymbol('<%').endSymbol('%>');
	});
  app.controller('myCtrl',function($http,$scope,$interval){
  $scope.device_name={!! json_encode($device_name) !!};
  var allDevice={!! json_encode($device_name) !!};
  $scope.device_location={!! json_encode($location) !!};
  $scope.selectedName={{$selected_device_id}};
  var selectedDeviceId={{$selected_device_id}};
  $scope.selectedlocation={{$location_id}};
  var AllDevices= {!! json_encode($AllDevices)!!};
  $scope.emptyData = true;
  $scope.showError = false;

   if($scope.selectedlocation == 0)
   {
    $scope.device_name = AllDevices;
   }
    $scope.changeLocation=function(id)
    {
      var location_id = id;
      if(location_id<=0){
       $scope.device_name = AllDevices;
       $scope.selectedName = selectedDeviceId;
       $scope.changePath($scope.selectedName,{{$auth_user}});
      }else{
           $http({
          'method': 'GET',
          'url': '/api/get_device_by_dashboard_location?locationId='+location_id
          }).then(function(response) {
            $scope.device_name=response.data.data;
            console.log($scope.device_name);
            $scope.selectedName=$scope.device_name[0].device_id;
             $scope.changePath($scope.selectedName,{{$auth_user}});
          },function(response) {
             $scope.device_name=[];
          });
       }

    }
    $scope.updatePath=function(id,auth_user)
        {
          $scope.device_id = id;
          $scope.auth_user=auth_user;
          var location_id = $scope.selectedlocation;
          console.log($scope.device_id);
          console.log($scope.ath_user);
          showError("Data will update in every {{$second}} seconds.");
          $interval(function () {
              $http({
                method:'POST',
                cache : true,
                url:'/api/get_devices?device_id='+$scope.device_id+'&user_id='+$scope.auth_user+'&location_id='+location_id,
                headers:{
                  'ApiKey':'{{env('API_KEY')}}'
                }
              })      
              .then(function success(response){
                var result=response.data;
                if(result.status.code==200){
                 $scope.devices=result.data;
                  console.log($scope.devices);
                  $scope.emptyData = true;
                  $scope.showError = false;
                      $scope.dev1=$scope.devices[0];
                      $scope.dev2=$scope.devices[1];
                      $scope.dev3=$scope.devices[2];
                      $scope.dev4=$scope.devices[3];
                      $scope.dev5=$scope.devices[4];
                      $scope.dev6=$scope.devices[5];
                      $scope.dev7=$scope.devices[6];
                      $scope.dev8=$scope.devices[7];
                      $scope.dev9=$scope.devices[8];
                      $scope.dev10=$scope.devices[9];

                      console.log($scope.dev1.min);
                      console.log($scope.dev1.max);
                      console.log($scope.dev1.unit_name);
                      console.log($scope.dev1.unit_value);

                        google.charts.load('current', {'packages':['gauge']});
                        google.charts.setOnLoadCallback(drawChart1);
                        google.charts.setOnLoadCallback(drawChart2);
                        google.charts.setOnLoadCallback(drawChart3);
                        google.charts.setOnLoadCallback(drawChart4);
                        google.charts.setOnLoadCallback(drawChart5);
                        google.charts.setOnLoadCallback(drawChart6);
                        google.charts.setOnLoadCallback(drawChart7);
                        google.charts.setOnLoadCallback(drawChart8);
                        google.charts.setOnLoadCallback(drawChart9);
                        google.charts.setOnLoadCallback(drawChart10);

                        function drawChart1() {
                          var dev1_name = $scope.dev1.unit_name;
                          var dev1_value = $scope.dev1.unit_value;
                          var dev1_min = $scope.dev1.min;
                          var dev1_max = $scope.dev1.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                          var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev1.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart2() {
                          var dev1_name = $scope.dev2.unit_name;
                          var dev1_value = $scope.dev2.unit_value;
                          var dev1_min = $scope.dev2.min;
                          var dev1_max = $scope.dev2.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div2'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev2.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart3() {
                          var dev1_name = $scope.dev3.unit_name;
                          var dev1_value = $scope.dev3.unit_value;
                          var dev1_min = $scope.dev3.min;
                          var dev1_max = $scope.dev3.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div3'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev3.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart4() {
                          var dev1_name = $scope.dev4.unit_name;
                          var dev1_value = $scope.dev4.unit_value;
                          var dev1_min = $scope.dev4.min;
                          var dev1_max = $scope.dev4.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                          var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div4'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev4.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart5() {
                          var dev1_name = $scope.dev5.unit_name;
                          var dev1_value = $scope.dev5.unit_value;
                          var dev1_min = $scope.dev5.min;
                          var dev1_max = $scope.dev5.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div5'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev5.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart6() {
                          var dev1_name = $scope.dev6.unit_name;
                          var dev1_value = $scope.dev6.unit_value;
                          var dev1_min = $scope.dev6.min;
                          var dev1_max = $scope.dev6.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div6'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev6.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart7() {
                          var dev1_name = $scope.dev7.unit_name;
                          var dev1_value = $scope.dev7.unit_value;
                          var dev1_min = $scope.dev7.min;
                          var dev1_max = $scope.dev7.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div7'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev7.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart8() {
                          var dev1_name = $scope.dev8.unit_name;
                          var dev1_value = $scope.dev8.unit_value;
                          var dev1_min = $scope.dev8.min;
                          var dev1_max = $scope.dev8.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div8'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev8.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart9() {
                          var dev1_name = $scope.dev9.unit_name;
                          var dev1_value = $scope.dev9.unit_value;
                          var dev1_min = $scope.dev9.min;
                          var dev1_max = $scope.dev9.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div9'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev9.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart10() {
                          var dev1_name = $scope.dev10.unit_name;
                          var dev1_value = $scope.dev10.unit_value;
                          var dev1_min = $scope.dev10.min;
                          var dev1_max = $scope.dev10.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div10'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev10.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }
                }
              },function error(response){
                console.log('Device not found');
                $scope.emptyData = false;
                $scope.showError = true;
                  $scope.dev1=$scope.devices[0];
                  $scope.dev2=$scope.devices[1];
                  $scope.dev3=$scope.devices[2];
                  $scope.dev4=$scope.devices[3];
                  $scope.dev5=$scope.devices[4];
                  $scope.dev6=$scope.devices[5];
                  $scope.dev7=$scope.devices[6];
                  $scope.dev8=$scope.devices[7];
                  $scope.dev9=$scope.devices[8];
                  $scope.dev10=$scope.devices[9];
                  $scope.dev1.unit_value=0;
                  $scope.dev2.unit_value=0;
                  $scope.dev3.unit_value=0;
                  $scope.dev4.unit_value=0;
                  $scope.dev5.unit_value=0;
                  $scope.dev6.unit_value=0;
                  $scope.dev7.unit_value=0;
                  $scope.dev8.unit_value=0;
                  $scope.dev9.unit_value=0;
                  $scope.dev10.unit_value=0;
              });
          }, {{$db_update_second}});
        };
    
    $scope.changePath=function(id,auth_user)
        {
          var deviceId=id;
          var authUser=auth_user;
          $scope.device_id = id;
          $scope.auth_user=auth_user;
          var location_id = $scope.selectedlocation;
          console.log($scope.device_id);
          console.log($scope.ath_user);
              $http({
                method:'POST',
                cache : true,
                url:'/api/get_devices?device_id='+$scope.device_id+'&user_id='+$scope.auth_user+'&location_id='+location_id,
                headers:{
                  'ApiKey':'{{env('API_KEY')}}'
                }
              })      
              .then(function success(response){
                var result=response.data;
                if(result.status.code==200){
                 $scope.devices=result.data;
                  console.log($scope.devices);
                  $scope.emptyData = true;
                  $scope.showError = false;
                      $scope.dev1=$scope.devices[0];
                      $scope.dev2=$scope.devices[1];
                      $scope.dev3=$scope.devices[2];
                      $scope.dev4=$scope.devices[3];
                      $scope.dev5=$scope.devices[4];
                      $scope.dev6=$scope.devices[5];
                      $scope.dev7=$scope.devices[6];
                      $scope.dev8=$scope.devices[7];
                      $scope.dev9=$scope.devices[8];
                      $scope.dev10=$scope.devices[9];

                      console.log($scope.dev1.min);
                      console.log($scope.dev1.max);
                      console.log($scope.dev1.unit_name);
                      console.log($scope.dev1.unit_value);

                        google.charts.load('current', {'packages':['gauge']});
                        google.charts.setOnLoadCallback(drawChart1);
                        google.charts.setOnLoadCallback(drawChart2);
                        google.charts.setOnLoadCallback(drawChart3);
                        google.charts.setOnLoadCallback(drawChart4);
                        google.charts.setOnLoadCallback(drawChart5);
                        google.charts.setOnLoadCallback(drawChart6);
                        google.charts.setOnLoadCallback(drawChart7);
                        google.charts.setOnLoadCallback(drawChart8);
                        google.charts.setOnLoadCallback(drawChart9);
                        google.charts.setOnLoadCallback(drawChart10);

                        function drawChart1() {
                          var dev1_name = $scope.dev1.unit_name;
                          var dev1_value = $scope.dev1.unit_value;
                          var dev1_min = $scope.dev1.min;
                          var dev1_max = $scope.dev1.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev1.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart2() {
                          var dev1_name = $scope.dev2.unit_name;
                          var dev1_value = $scope.dev2.unit_value;
                          var dev1_min = $scope.dev2.min;
                          var dev1_max = $scope.dev2.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div2'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev2.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart3() {
                          var dev1_name = $scope.dev3.unit_name;
                          var dev1_value = $scope.dev3.unit_value;
                          var dev1_min = $scope.dev3.min;
                          var dev1_max = $scope.dev3.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div3'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev3.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart4() {
                          var dev1_name = $scope.dev4.unit_name;
                          var dev1_value = $scope.dev4.unit_value;
                          var dev1_min = $scope.dev4.min;
                          var dev1_max = $scope.dev4.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };
                          var chart = new google.visualization.Gauge(document.getElementById('chart_div4'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev4.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart5() {
                          var dev1_name = $scope.dev5.unit_name;
                          var dev1_value = $scope.dev5.unit_value;
                          var dev1_min = $scope.dev5.min;
                          var dev1_max = $scope.dev5.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div5'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev5.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart6() {
                          var dev1_name = $scope.dev6.unit_name;
                          var dev1_value = $scope.dev6.unit_value;
                          var dev1_min = $scope.dev6.min;
                          var dev1_max = $scope.dev6.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                          var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div6'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev6.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart7() {
                          var dev1_name = $scope.dev7.unit_name;
                          var dev1_value = $scope.dev7.unit_value;
                          var dev1_min = $scope.dev7.min;
                          var dev1_max = $scope.dev7.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div7'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev7.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart8() {
                          var dev1_name = $scope.dev8.unit_name;
                          var dev1_value = $scope.dev8.unit_value;
                          var dev1_min = $scope.dev8.min;
                          var dev1_max = $scope.dev8.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div8'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev8.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart9() {
                          var dev1_name = $scope.dev9.unit_name;
                          var dev1_value = $scope.dev9.unit_value;
                          var dev1_min = $scope.dev9.min;
                          var dev1_max = $scope.dev9.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div9'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev9.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart10() {
                          var dev1_name = $scope.dev10.unit_name;
                          var dev1_value = $scope.dev10.unit_value;
                          var dev1_min = $scope.dev10.min;
                          var dev1_max = $scope.dev10.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };
                          var chart = new google.visualization.Gauge(document.getElementById('chart_div10'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev10.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }
                        $scope.updatePath(deviceId,authUser);
                }
              },function error(response){
                console.log('Device not found');
                $scope.emptyData = false;
                $scope.showError = true;
              });
            
        };

    var init = $scope.initialPath=function(id,auth_user)
        {
          $scope.device_id = id;
          $scope.auth_user=auth_user;
          var location_id = $scope.selectedlocation;
          console.log($scope.device_id);
          console.log($scope.ath_user);
              $http({
                method:'POST',
                cache : true,
                url:'/api/get_devices?device_id='+$scope.device_id+'&user_id='+$scope.auth_user+'&location_id='+location_id,
                headers:{
                  'ApiKey':'{{env('API_KEY')}}'
                }
              })      
              .then(function success(response){
                var result=response.data;
                if(result.status.code==200){
                 $scope.devices=result.data;
                  console.log($scope.devices);
                  $scope.emptyData = true;
                  $scope.showError = false;
                      $scope.dev1=$scope.devices[0];
                      $scope.dev2=$scope.devices[1];
                      $scope.dev3=$scope.devices[2];
                      $scope.dev4=$scope.devices[3];
                      $scope.dev5=$scope.devices[4];
                      $scope.dev6=$scope.devices[5];
                      $scope.dev7=$scope.devices[6];
                      $scope.dev8=$scope.devices[7];
                      $scope.dev9=$scope.devices[8];
                      $scope.dev10=$scope.devices[9];

                      console.log($scope.dev1.min);
                      console.log($scope.dev1.max);
                      console.log($scope.dev1.unit_name);
                      console.log($scope.dev1.unit_value);

                        google.charts.load('current', {'packages':['gauge']});
                        google.charts.setOnLoadCallback(drawChart1);
                        google.charts.setOnLoadCallback(drawChart2);
                        google.charts.setOnLoadCallback(drawChart3);
                        google.charts.setOnLoadCallback(drawChart4);
                        google.charts.setOnLoadCallback(drawChart5);
                        google.charts.setOnLoadCallback(drawChart6);
                        google.charts.setOnLoadCallback(drawChart7);
                        google.charts.setOnLoadCallback(drawChart8);
                        google.charts.setOnLoadCallback(drawChart9);
                        google.charts.setOnLoadCallback(drawChart10);

                        function drawChart1() {
                          var dev1_name = $scope.dev1.unit_name;
                          var dev1_value = $scope.dev1.unit_value;
                          var dev1_min = $scope.dev1.min;
                          var dev1_max = $scope.dev1.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev1.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart2() {
                          var dev1_name = $scope.dev2.unit_name;
                          var dev1_value = $scope.dev2.unit_value;
                          var dev1_min = $scope.dev2.min;
                          var dev1_max = $scope.dev2.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div2'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev2.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart3() {
                          var dev1_name = $scope.dev3.unit_name;
                          var dev1_value = $scope.dev3.unit_value;
                          var dev1_min = $scope.dev3.min;
                          var dev1_max = $scope.dev3.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div3'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev3.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart4() {
                          var dev1_name = $scope.dev4.unit_name;
                          var dev1_value = $scope.dev4.unit_value;
                          var dev1_min = $scope.dev4.min;
                          var dev1_max = $scope.dev4.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };
                          var chart = new google.visualization.Gauge(document.getElementById('chart_div4'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev4.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart5() {
                          var dev1_name = $scope.dev5.unit_name;
                          var dev1_value = $scope.dev5.unit_value;
                          var dev1_min = $scope.dev5.min;
                          var dev1_max = $scope.dev5.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div5'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev5.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart6() {
                          var dev1_name = $scope.dev6.unit_name;
                          var dev1_value = $scope.dev6.unit_value;
                          var dev1_min = $scope.dev6.min;
                          var dev1_max = $scope.dev6.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                          var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div6'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev6.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart7() {
                          var dev1_name = $scope.dev7.unit_name;
                          var dev1_value = $scope.dev7.unit_value;
                          var dev1_min = $scope.dev7.min;
                          var dev1_max = $scope.dev7.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div7'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev7.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart8() {
                          var dev1_name = $scope.dev8.unit_name;
                          var dev1_value = $scope.dev8.unit_value;
                          var dev1_min = $scope.dev8.min;
                          var dev1_max = $scope.dev8.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div8'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev8.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart9() {
                          var dev1_name = $scope.dev9.unit_name;
                          var dev1_value = $scope.dev9.unit_value;
                          var dev1_min = $scope.dev9.min;
                          var dev1_max = $scope.dev9.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };

                          var chart = new google.visualization.Gauge(document.getElementById('chart_div9'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev9.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }

                        function drawChart10() {
                          var dev1_name = $scope.dev10.unit_name;
                          var dev1_value = $scope.dev10.unit_value;
                          var dev1_min = $scope.dev10.min;
                          var dev1_max = $scope.dev10.max;
                          var data = google.visualization.arrayToDataTable([
                            ['Label', 'Value'],
                            [String(dev1_name), dev1_value],
                          ]);

                           var options = {
                            width: {{$chart_width}}, height: {{$chart_height}},
                            redFrom: {{$red_from}}, redTo: {{$red_to}},
                            yellowFrom:{{$yellow_from}}, yellowTo: {{$yellow_to}},
                            minorTicks: {{$minor_ticks}},
                            min: dev1_min,
                            max: dev1_max
                          };
                          var chart = new google.visualization.Gauge(document.getElementById('chart_div10'));

                          chart.draw(data, options);

                          setInterval(function() {
                            var dev1_value = $scope.dev10.unit_value;
                            data.setValue(0, 1, dev1_value);
                            chart.draw(data, options);
                          }, {{$interval_chart_second}});
                        }
                        $scope.updatePath({{$selected_device_id}},{{$auth_user}});
                }
              },function error(response){
                console.log('Device not found');
                $scope.emptyData = false;
                $scope.showError = true;
              });

        };
    init({{$selected_device_id}},{{$auth_user}});
    $(window).resize(function(){
      drawChart1();
      drawChart2();
      drawChart3();
      drawChart4();
      drawChart5();
      drawChart6();
      drawChart7();
      drawChart8();
      drawChart9();
      drawChart10();
    });

});

   function showError($message) {
    console.log($message);
      $('#errorMessage').html($message);
      $('#errorModal').modal();
    };

</script>
@endsection
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::post('sendcontact', 'ContactController@sentContactInfo');
  
    Route::post('/language', array (
            'Middleware'=>'LanguageSwitcher',
            'uses'=>'LanguageController@index',
        )); 
Route::group(['prefix' => 'api'], function() {    
 Route::group(['prefix' => 'v1','middleware'=>'api'], function() {
        Route::post('update_device','Api\DataController@updateDevice');
        Route::post('update_device_detail','Api\DataController@updateDeviceDetail');
        Route::get('send_mail','Api\DataController@sendMailToAdmin');
        Route::post('insert_device_data', 'Api\DataController@insertDeviceData');        
    });
        Route::get('get_device_by_location','Api\DataController@getDevicesByLocation');
        Route::get('get_device_by_dashboard_location','Api\DataController@getDevicesByDashboardLocation');
       Route::post('get_devices','Api\DataController@getDevices');
});

Route::get('/', function () {
    return redirect()->route('user.home');
});

Route::get('/chart','TestController@index');

Route::get('control-panel/login', ['as'=>'user.get.login','uses'=>'Auth\AuthController@showLoginForm'])->middleware('web');

Route::group(['prefix' => 'control-panel','middleware' =>['web','auth']], function() {
    
    Route::get('/','HomeController@index');
    Route::get('/home', ['as'=>'user.home','uses'=>'HomeController@index']);

   Route::group(['prefix' => 'device'], function() {
        Route::get('/',['as'=>'device.index','uses'=>'Admin\DeviceController@index']);
        Route::get('create',['as'=>'device.create','uses'=>'Admin\DeviceController@create']);
        Route::post('save',['as'=>'device.save','uses'=>'Admin\DeviceController@save']);  
        Route::get('edit',['as'=>'device.edit','uses'=>'Admin\DeviceController@edit']);    
        Route::post('update',['as'=>'device.update','uses'=>'Admin\DeviceController@update']);    
        Route::post('delete', ['as'=>'device.delete','uses'=>'Admin\DeviceController@delete']);

    });

   Route::group(['prefix'=>'location'],function(){
        Route::get('/',['as'=>'location.index','uses'=>'Admin\LocationController@index']);
        Route::get('create',['as'=>'location.create','uses'=>'Admin\LocationController@create']);
        Route::post('save',['as'=>'location.save','uses'=>'Admin\LocationController@save']);  
        Route::get('edit',['as'=>'location.edit','uses'=>'Admin\LocationController@edit']);    
        Route::post('update',['as'=>'location.update','uses'=>'Admin\LocationController@update']);    
        Route::post('delete', ['as'=>'location.delete','uses'=>'Admin\LocationController@delete']);

   });

    Route::group(['prefix'=>'range'],function(){
        Route::get('/',['as'=>'range.index','uses'=>'Admin\RangeController@index']);
        Route::get('create',['as'=>'range.create','uses'=>'Admin\RangeController@create']);
        Route::post('save',['as'=>'range.save','uses'=>'Admin\RangeController@save']);  
        Route::get('edit',['as'=>'range.edit','uses'=>'Admin\RangeController@edit']);    
        Route::post('update',['as'=>'range.update','uses'=>'Admin\RangeController@update']);    
        Route::post('delete', ['as'=>'range.delete','uses'=>'Admin\RangeController@delete']);

   });
   
    Route::get('logs', ['as'=>'log','uses'=>'\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
    Route::post('login', ['as'=>'user.post.login','uses'=>'Auth\AuthController@login']);
    Route::get('logout', ['as'=>'user.get.logout','uses'=>'Auth\AuthController@logout']);
    Route::get('reset', ['as'=>'user.password.reset','uses'=>'Auth\PasswordController@showResetForm']);

        Route::group(['prefix' => 'users'], function() {
            Route::get('/',['as'=>'user.index','uses'=>'Admin\UserController@index']);
            Route::get('create',['as'=>'user.create','uses'=>'Admin\UserController@create']);    
            Route::post('save',['as'=>'user.save','uses'=>'Admin\UserController@save']);    
            Route::get('edit',['as'=>'user.edit','uses'=>'Admin\UserController@edit']);    
            Route::post('update',['as'=>'user.update','uses'=>'Admin\UserController@update']);    
            Route::post('delete', ['as'=>'user.delete','uses'=>'Admin\UserController@delete']);     
            Route::get('profile',['as'=>'user.profile.show','uses'=>'Admin\UserController@showProfile']);
            Route::post('update_password',['as'=>'user.profile.change_password','uses'=>'Admin\UserController@updatePassword']);//login user change is password
            Route::post('change_password',['as'=>'user.profile.update_password','uses'=>'Admin\UserController@changePassword']);//Admin change user's password
            Route::get('/graphs',['as'=>'admin.users_graphs','uses'=>'Admin\UserController@showUserRegisterationGraph'] );
        });
        
        Route::group(['prefix' => 'dashboard'], function() {
            Route::get('/',['as'=>'dashboard.create','uses'=>'Admin\DeviceController@dashboard']);
            Route::get('get_by_location',['as'=>'dashboard.getLocation','uses'=>'Admin\DeviceController@getByLocation']);
            Route::get('create',['as'=>'device.create','uses'=>'Admin\DeviceController@create']);

        });
        Route::group(['prefix' => 'wifi_setting'], function() {
            Route::get('/','Admin\SettingController@wifiSetting');
            Route::post('/', ['as'=>'wifi_setting.save','uses'=>'Admin\SettingController@wifiSettingSave']);
        });

        Route::group(['prefix' => 'reports'], function() {
            // Route::get('by_time',['as'=>'electrical_report_by_time','uses'=>'Admin\ReportController@electricalReportByTime']);
            // Route::get('by_hour',['as'=>'electrical_report_by_hour','uses'=>'Admin\ReportController@electricalReportByHour']);
            Route::get('by_day',['as'=>'electrical_report_by_day','uses'=>'Admin\ReportController@electricalReportByDay']);
            Route::get('by_month',['as'=>'electrical_report_by_month','uses'=>'Admin\ReportController@electricalReportByMonth']);
            Route::get('by_year',['as'=>'electrical_report_by_year','uses'=>'Admin\ReportController@electricalReportByYear']);    
            
            Route::get('w_report/{group_by}',['as'=>'daily_w_report','uses'=>'Admin\ReportController@showDailyWReport']);  
            Route::get('wh_report_by_date_range',['as'=>'wh_report_by_date_range','uses'=>'Admin\ReportController@showWhReportByDateRange']);    
            Route::get('wh_report_by_hour',['as'=>'wh_report_by_hour','uses'=>'Admin\ReportController@showWhReportByHour']);    
            Route::get('wh_report_by_day',['as'=>'wh_report_by_day','uses'=>'Admin\ReportController@showWhReportByDay']);    
            Route::get('wh_report_by_month',['as'=>'wh_report_by_month','uses'=>'Admin\ReportController@showWhReportByMonth']);    
            
            
        });

       Route::group(['prefix' => 'device_settings'], function() {
        Route::get('/', ['as'=>'device_setting.create','uses'=>'Admin\SettingController@deviceCreate']);
        Route::post('/', ['as'=>'device_setting.save','uses'=>'Admin\SettingController@deviceSave']);
       
         });  
        Route::group(['prefix' => 'report_settings'], function() {
        Route::get('/', ['as'=>'report_setting.create','uses'=>'Admin\SettingController@reportCreate']);
        Route::post('/', ['as'=>'report_setting.save','uses'=>'Admin\SettingController@reportSave']);
       
         });
        Route::group(['prefix' => 'dashboard_settings'], function() {
            Route::get('/', ['as'=>'dashboard_setting.create','uses'=>'Admin\SettingController@dashboardSetting']);
            Route::post('/', ['as'=>'dashboard_setting.update','uses'=>'Admin\SettingController@updateDashboardSetting']);  
         });       

       Route::group(['prefix' => 'unit_settings'], function() {
        Route::get('/', ['as'=>'unit_settings.show','uses'=>'Admin\SettingController@showUnitSetting']);
        Route::post('/', ['as'=>'unit_settings.update','uses'=>'Admin\SettingController@updateUnitSetting']);
         });
        
        Route::group(['prefix' => 'excel_export'], function() {
            Route::get('/', ['as'=>'excel_export','uses'=>'Admin\ReportController@showExcelExport']);
            Route::post('/', ['as'=>'post.excel_export','uses'=>'Admin\ReportController@exportExcel']);
        });
});
   

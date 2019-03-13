<?php 

namespace PowerMs\MyLibs\Repositories;

use PowerMs\MyLibs\Models\DeviceDetail;
use PowerMs\MyLibs\Repositories\BaseRepository;

class DeviceDetailRepository extends BaseRepository {

	protected $model;
	public function __construct(DeviceDetail $model)
	{
		$this->model = $model;
	}
	/*
	public function getHourlyReport($device_id,$columns,$date)
	{
		//convert d-m-yyyy to yyyy-m-d
		$date=date_create_from_format('d-m-Y',$date);
		$date=$date->format('Y-m-d');
		//prepair retrieve cols string
		$retrieve_columns=" date_format(created_at,'%h %p') hour,".implode(",", $columns);
		$sql='select '.$retrieve_columns.' from device_detail where device_id = '.$device_id.' and date(created_at)=date("'.$date.'") group by hour(created_at) order by hour(created_at)';
		// dd($sql);
		$res=\DB::select($sql);
		return $res;
	}

	public function getDailyReport($device_id,$columns,$month,$year)
	{
		//prepair retrieve cols string
		$retrieve_columns=" date_format(created_at,'%d-%m-%Y') created_at,".implode(",", $columns);					 
		$sql='select '.$retrieve_columns.' from device_detail where device_id = '.$device_id.' and month(created_at)='.$month.' and year(created_at)='.$year.' group by date(created_at) order by created_at';
		// dd($sql);
		$res=\DB::select($sql);
		return $res;
	}

	public function getMonthlyReport($device_id,$columns,$year)
	{
		//prepair retrieve cols string
		$retrieve_columns=" monthname(created_at) month,".implode(",", $columns);
		$sql='select '.$retrieve_columns.' from device_detail where device_id = '.$device_id.' and year(created_at)='.$year.' group by month(created_at)';
		// dd($sql);
		$res=\DB::select($sql);
		return $res;
	}

	public function getYearlyReport($device_id,$columns,$start_year,$end_year)
	{
		$retrieve_columns=" concat(year(date(created_at)),' Yr') year,".implode(",", $columns);			
		$sql='select '.$retrieve_columns.' from device_detail where device_id = '.$device_id.' and year(created_at)>='.$start_year.' and year(created_at) <= '.$end_year.' group by year(created_at) order by year(created_at)';		
		$res=\DB::select($sql);
		return $res;
	}

	public function getTimelyReport($device_id,$columns,$start_time,$end_time)
	{
		//format datetime to yyyy-m-dd H:i format
		$date=date_create_from_format('d-m-Y h:i A',$start_time);
		$start_time=$date->format('Y-m-d H:i:s');
		$date=date_create_from_format('d-m-Y h:i A',$end_time);
		$end_time=$date->format('Y-m-d H:i:s');

		$retrieve_columns=" date_format(created_at,'%h:%i %p') time,".implode(",", $columns);
		$sql='select '.$retrieve_columns.' from device_detail where device_id ='.$device_id.' and created_at >="'.$start_time.'" and created_at <= "'.$end_time.'" group by minute(created_at) order by created_at';
		// dd($sql);
		$res=\DB::select($sql);
		return $res;
	}*/

	public function getMinMaxValueFor_W_Report($device_id,$date,$measureUnit='W')
	{
		//convert d-m-yyyy to yyyy-m-d
		$date=date_create_from_format('d-m-Y',$date);
		$date=$date->format('Y-m-d');
		$divideBy=1;
		// if($measureUnit==='KW')
		// 	$divideBy=1000;
		// else if($measureUnit==='MW')
		// 	$divideBy=1000000;
		// else if($measureUnit==='GW')
		// 	$divideBy=1000000000;

		$sql="SELECT round(min(W)/".$divideBy.",2) as min_value,round(max(W)/".$divideBy.",2) max_value FROM `device_detail` WHERE date(created_at)='".$date."' AND device_id=".$device_id." and W>0";	
		$res=\DB::select($sql);		
		// dd($sql,$res);
		return $res;
	}

	public function getDaily_W_Report($device_id,$date,$group_by,$measureUnit='W')
	{
		$sql="";
		//convert d-m-yyyy to yyyy-m-d
		$date=date_create_from_format('d-m-Y',$date);
		$date=$date->format('Y-m-d');
		$divideBy=1;
		// if($measureUnit==='KW')
		// 	$divideBy=1000;
		// else if($measureUnit==='MW')
		// 	$divideBy=1000000;
		// else if($measureUnit==='GW')
		// 	$divideBy=1000000000;

		if($group_by=='hour')
			$sql='select year(created_at) year,month(created_at) month,day(created_at) day, hour(created_at) hour,minute(created_at) minute,second(created_at) second, round(W/'.$divideBy.') as W  from device_detail where device_id = '.$device_id.' and date(created_at)=date("'.$date.'") group by hour(created_at) order by hour(created_at)';			
		else if($group_by=='30mins')
			$sql='select year(created_at) year,month(created_at) month,day(created_at) day, hour(created_at) hour,minute(created_at) minute,second(created_at) second, round(W/'.$divideBy.') as W  from device_detail where device_id = '.$device_id.' and date(created_at)=date("'.$date.'") group by round(UNIX_TIMESTAMP(created_at)/(30*60)) order by created_at';			
		else if($group_by=='15mins')
			$sql='select year(created_at) year,month(created_at) month,day(created_at) day, hour(created_at) hour,minute(created_at) minute,second(created_at) second, round(W/'.$divideBy.') as W  from device_detail where device_id = '.$device_id.' and date(created_at)=date("'.$date.'") group by round(UNIX_TIMESTAMP(created_at)/(15*60)) order by created_at';		
		$res=\DB::select($sql);
		// dd($sql,$res);
		return $res;
	}

	public function getDailyReportForFwh($device_id,$start_date,$end_date,$measureUnit='W')
	{
		$divideBy=1;
		// if($measureUnit==='KW')
		// 	$divideBy=1000;
		// else if($measureUnit==='MW')
		// 	$divideBy=1000000;
		// else if($measureUnit==='GW')
		// 	$divideBy=1000000000;

		$date=date_create_from_format('d-m-Y',$start_date);
		$date=$date->modify('-1 day');// decrease start date to get starting value
		$start_date=$date->format('Y-m-d');
		$date=date_create_from_format('d-m-Y',$end_date);
		$end_date=$date->format('Y-m-d');

		$sql="SELECT date_format(created_at,'%d-%m-%Y') day,round(FWh/".$divideBy.",2) FWh FROM device_detail WHERE id IN (SELECT max(id) FROM device_detail WHERE date(created_at)>='".$start_date."' and date(created_at)<='".$end_date."' and device_id=".$device_id." GROUP BY date(created_at) ) ORDER BY created_at ASC";
		$res=\DB::select($sql);
		// dd($sql,$res);
		return $res;
	}

	public function get_Wh_ReportByHour($device_id,$date,$measureUnit='W')
	{
		$divideBy=1;
		// if($measureUnit==='KW')
		// 	$divideBy=1000;
		// else if($measureUnit==='MW')
		// 	$divideBy=1000000;
		// else if($measureUnit==='GW')
		// 	$divideBy=1000000000;

		$date=$date2=date_create_from_format('d-m-Y',$date);
		$date=$date->format('Y-m-d');
		$yesterday=$date2->modify('-1 day');
		$yesterday=$yesterday->format('Y-m-d');
		
		$sql="SELECT created_at,date_format(Mx.created_at,'%h %p') hour,round(FWh/".$divideBy.",2) FWh FROM (
			(SELECT * FROM device_detail WHERE date(created_at)='".$yesterday."' and device_id=".$device_id." ORDER BY id DESC LIMIT 1) UNION
    		(SELECT * FROM device_detail WHERE id IN (SELECT max(id) FROM device_detail WHERE date(created_at)='".$date."' and device_id=".$device_id." GROUP BY hour(created_at)) )) AS Mx  ORDER BY created_at ASC";
		$res=\DB::select($sql);
		// dd($sql,$res);
		return $res;
	}

	public function get_Wh_ReportByDay($device_id,$month_year,$measureUnit='W')
	{
		$divideBy=1;
		// if($measureUnit==='KW')
		// 	$divideBy=1000;
		// else if($measureUnit==='MW')
		// 	$divideBy=1000000;
		// else if($measureUnit==='GW')
		// 	$divideBy=1000000000;

		$month_year=explode('-', $month_year);//split month-year string		
		if($month_year[0]<1)// if month is january, need to decrease year and get 12 for december
		{
			$year=$month_year[1]-1;
			$month=12;			
		}
		else// need to decrease month
		{
			$year=$month_year[1];
			$month=$month_year[0]-1;
		}
		$prevous_month_sql="SELECT * FROM device_detail WHERE month(created_at)=".$month." and year(created_at)=".$year." and device_id=".$device_id." ORDER BY id DESC LIMIT 1";			

    	$sql="SELECT id,created_at,date_format(Mx.created_at,'%d-%m-%Y') day,round(FWh/".$divideBy.",2) FWh FROM (
			(".$prevous_month_sql.") UNION
			(SELECT * FROM device_detail WHERE id IN (SELECT max(id) FROM device_detail WHERE month(created_at)=".$month_year[0]." and year(created_at)=".$month_year[1]." and device_id=".$device_id." GROUP BY day(created_at)) )) AS Mx ORDER BY created_at ASC";
		$res=\DB::select($sql);
		// dd($sql,$res);
		return $res;
	}

	public function get_Wh_ReportByMonth($device_id,$year,$measureUnit='W')	
	{
		$divideBy=1;
		// if($measureUnit==='KW')
		// 	$divideBy=1000;
		// else if($measureUnit==='MW')
		// 	$divideBy=1000000;
		// else if($measureUnit==='GW')
		// 	$divideBy=1000000000; 

		$previous_year=$year-1;
		$previous_december_sql="SELECT * FROM device_detail WHERE year(created_at)=".$previous_year." and month(created_at)=12 and device_id=".$device_id." ORDER BY id DESC LIMIT 1";
		$sql="SELECT id,created_at,date_format(created_at,'%M') month,round(FWh/".$divideBy.",2) FWh FROM ((".$previous_december_sql.") UNION
    	(SELECT * FROM device_detail WHERE id IN (SELECT max(id) FROM device_detail WHERE year(created_at)=".$year." and device_id=".$device_id." GROUP BY month(created_at)) )) As Mx ORDER BY id";
		$res=\DB::select($sql);
		// dd($sql,$res);
		return $res;
	}

	public function getDataForExport($device_id,$start_date,$end_date,$selected_columns)
	{
		$date=date_create_from_format('d-m-Y',$start_date);
		$start_date=$date->format('Y-m-d');
		$date=date_create_from_format('d-m-Y',$end_date);
		$end_date=$date->format('Y-m-d');
		$sql="SELECT ".$selected_columns.",created_at FROM  device_detail WHERE device_id=".$device_id." AND date(created_at)>='".$start_date."' AND date(created_at)<='".$end_date."' ORDER BY created_at ASC";
		$res=\DB::select($sql);
		return $res;
	}
}
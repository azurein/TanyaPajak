<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Response;

class RekapController extends Controller
{
	public function get_user(){
		$start = Input::get("start");
		$end = Input::get("end");
		$period = Input::get("period");
		if(empty($start)||empty($end)){			
			return Response::json(array(
				'error' => false,
				"message"=>"Start date and End date must be filled")
			);
		}
		$validStart = explode("-", $start);
		$validEnd = explode("-", $end);
		if(!checkdate($validStart[1],$validStart[2],$validStart[0])||!checkdate($validEnd[1],$validEnd[2],$validEnd[0])){
			return Response::json(array(
				'error' => false,
				"message"=>"Start date and End date must be valid date")
			);
		}
		$logData = null;
		switch($period){
			case 1:
				$logData = DB::select("SELECT DATE(log_time) groupTime,COUNT(DISTINCT user_id) AS countUser  FROM user_log WHERE edit_by='frontend' AND stsrc=? AND DATE(log_time) BETWEEN ? AND ? GROUP BY groupTime",["A",$start,$end]);
			break;
			case 2:
				$logData = DB::select("SELECT MONTH(log_time) groupTime,COUNT(DISTINCT user_id) AS countUser  FROM user_log WHERE edit_by='frontend' AND stsrc=? AND DATE(log_time) BETWEEN ? AND ? GROUP BY groupTime",["A",$start,$end]);
			break;
			case 3:
				$logData = DB::select("SELECT YEAR(log_time) groupTime,COUNT(DISTINCT user_id) AS countUser  FROM user_log WHERE edit_by='frontend' AND stsrc=? AND DATE(log_time) BETWEEN ? AND ? GROUP BY groupTime",["A",$start,$end]);
			break;
		}
		if(empty($logData)){
			return Response::json(array(
				'error' => false,
				"message"=>"Web log data is empty")
			);
		}
        return Response::json(array(
			'error' => true,
			"log_data"=>$logData),
			200
		);
	}
	public function get_user_mobile(){
		$start = Input::get("start");
		$end = Input::get("end");
		$period = Input::get("period");
		if(empty($start)||empty($end)){			
			return Response::json(array(
				'error' => false,
				"message"=>"Start date and End date must be filled")
			);
		}
		$validStart = explode("-", $start);
		$validEnd = explode("-", $end);
		if(!checkdate($validStart[1],$validStart[2],$validStart[0])||!checkdate($validEnd[1],$validEnd[2],$validEnd[0])){
			return Response::json(array(
				'error' => false,
				"message"=>"Start date and End date must be valid date")
			);
		}
		$logData = null;
		switch($period){
			case 1:
				$logData = DB::select("SELECT DATE(log_time) groupTime,COUNT(DISTINCT user_id) AS countUser  FROM user_log WHERE edit_by='mobile' AND stsrc=? AND DATE(log_time) BETWEEN ? AND ? GROUP BY groupTime",["A",$start,$end]);
			break;
			case 2:
				$logData = DB::select("SELECT MONTH(log_time) groupTime,COUNT(DISTINCT user_id) AS countUser  FROM user_log WHERE edit_by='mobile' AND stsrc=? AND DATE(log_time) BETWEEN ? AND ? GROUP BY groupTime",["A",$start,$end]);
			break;
			case 3:
				$logData = DB::select("SELECT YEAR(log_time) groupTime,COUNT(DISTINCT user_id) AS countUser  FROM user_log WHERE edit_by='mobile' AND stsrc=? AND DATE(log_time) BETWEEN ? AND ? GROUP BY groupTime",["A",$start,$end]);
			break;
		}
		if(empty($logData)){
			return Response::json(array(
				'error' => false,
				"message"=>"Mobile log data is empty")
			);
		}
        return Response::json(array(
			'error' => true,
			"log_data"=>$logData),
			200
		);
	}
}

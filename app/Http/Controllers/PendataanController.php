<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use Response;
use App\Http\Controllers\Controller;

class PendataanController extends Controller
{
	public static function loadType()
	{
		$tax = DB::select('select tax_type_id,tax_type_name,tax_type_descr,percentage,is_shown
								from temp_tax_type
								where stsrc = ? AND tax_type_id IN('.Input::get("editId").')', ["A"]);
		return $tax;
	}
	public static function get()
	{
		$tax = DB::select('select tax_type_id,tax_type_name,tax_type_descr,percentage,is_shown
								from temp_tax_type
								where stsrc = ? ', ["A"]);
		return $tax;
	}
    public function add()
    {
		$type = Input::get("type");
		$desc = Input::get("desc");
		$percent = Input::get("percent");
		$shown = Input::get("shown");
		if(empty($percent)){
			$percent = 0;
		}
		if(empty($type)){
			return Response::json(array(
				'error' => false,
				'message' => "Tax type must be filled")
			);
		}
		if(!is_numeric($percent)){
			return Response::json(array(
				'error' => false,
				'message' => "Tax percent must be number")
			);
		}
		$tax = DB::select('SELECT tax_type_id FROM temp_tax_type WHERE stsrc = ? AND tax_type_name = ?', ["A",$type]);
		if(!empty($tax)){
			return Response::json(array(
				'error' => false,
				'message' => "Tax type already exists")
			);
		}
		$insert = DB::insert('INSERT INTO temp_tax_type SELECT MAX(tax_type_id)+1,?,?,?,?,?,?,NOW() FROM temp_tax_type', [$type,$desc,$percent,$shown,"A",Session::get("user_id")]);
		if(!$insert){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
		else{
			return Response::json(array('error' => true,'message' => "New tax type has been inserted"),
				200
			);
		}
    }
    public function edit()
    {
		$type = Input::get("type");
		$desc = Input::get("desc");
		$tax = Input::get("tax");
		$shown = Input::get("shown");
		if(empty($type)){
			return Response::json(array(
				'error' => false,
				'message' => "Tax type is empty")
			);
		}		
		if(empty($tax)){
			$tax = 0;
		}		
		$searchId = DB::select('SELECT tax_type_id FROM temp_tax_type WHERE stsrc = ? AND tax_type_name = ?', ["A",$type]);
		$update = DB::update('UPDATE temp_tax_type SET tax_type_descr=?,is_shown=?,percentage=?,stsrc=?,edit_by=?,edit_at=NOW() WHERE tax_type_id=?', [$desc,$shown,$tax,"A",Session::get("user_id"),$searchId[0]->tax_type_id]);
		if(!$update){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
        return Response::json(array('error' => true,'message' => "Tax type has been updated"),
			200
		);
    }
    public function delete()
    {
		$list = Input::get("list");
		if($list===NULL){
			return Response::json(array(
				'error' => false,
				'message' => "Please select item(s)")
			);
		}
		$update = DB::update("UPDATE temp_tax_type SET stsrc=?,edit_by=?,edit_at=NOW() WHERE tax_type_id IN(".join(",",$list).")", ["D",Session::get("user_id")]);
		if(!$update){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
        return Response::json(array('error' => true,'message' => "Tax type has been deleted"),
			200
		);
    }
}
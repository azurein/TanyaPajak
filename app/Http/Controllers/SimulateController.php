<?php

namespace App\Http\Controllers;
use DB;
use Input;
use Session;

class SimulateController extends Controller
{
	public function backSimulate(){
		$curr = Input::get("id");
		return ["result"=>DB::table("temp_tax_qa")
		->select("tax_qa_id", "question","answer","priority")
		->where("parent_tax_qa_id",function($query) use($curr){
			$query
				->select("parent_tax_qa_id")
				->from("temp_tax_qa")->where("tax_qa_id",$curr);
		})
		->where("stsrc","!=","D")->get()];
	}
	public function nextSimulate(){
		$curr = Input::get("id");
		$checkLast = DB::table("temp_tax_qa_detail")
						->join("temp_tax_type","temp_tax_qa_detail.tax_type_id","=","temp_tax_type.tax_type_id")
						->select("temp_tax_qa_detail.tax_type_id","temp_tax_qa_detail.nominal","temp_tax_qa_detail.percentage","temp_tax_type.tax_type_name")
						->where("temp_tax_type.stsrc","!=","D")
						->where("temp_tax_qa_detail.stsrc","!=","D")
						->where("temp_tax_qa_detail.tax_qa_id",$curr)
						->get();
		if(count($checkLast)>0){
			return ["endQuestion"=>true,"result"=>$curr];
		}
		else{
			return ["endQuestion"=>false,"result"=>DB::table("temp_tax_qa")
			->select("tax_qa_id", "question","answer","priority")
			->where("parent_tax_qa_id",$curr)
			->where("stsrc","!=","D")->get()];
		}
	}
	public function back(){
		$curr = Input::get("id");
		return ["result"=>DB::table("tax_qa")
		->select("tax_qa_id", "question","answer","priority")
		->where("parent_tax_qa_id",function($query) use($curr){
			$query
				->select("parent_tax_qa_id")
				->from("temp_tax_qa")->where("tax_qa_id",$curr);
		})
		->where("stsrc","!=","D")->get()];
	}
	public function next(){
		$curr = Input::get("id");
		$checkLast = DB::table("tax_qa_detail")
						->join("tax_type","tax_qa_detail.tax_type_id","=","tax_type.tax_type_id")
						->select("tax_qa_detail.tax_type_id","tax_qa_detail.nominal","tax_qa_detail.percentage","tax_type.tax_type_name")
						->where("tax_type.stsrc","!=","D")
						->where("tax_qa_detail.stsrc","!=","D")
						->where("tax_qa_detail.tax_qa_id",$curr)
						->get();
		if(count($checkLast)>0){
			return ["endQuestion"=>true,"result"=>$curr];
		}
		else{
			return ["endQuestion"=>false,"result"=>DB::table("tax_qa")
			->select("tax_qa_id", "question","answer","priority","parent_tax_qa_id")
			->where("parent_tax_qa_id",$curr)
			->where("stsrc","!=","D")->get()];
		}
	}
	public function publish(){
		DB::update("UPDATE tax_qa SET stsrc='D',edit_by='".Session::get("user_id")."',edit_at=NOW()");
		DB::update("UPDATE tax_qa_detail SET stsrc='D',edit_by='".Session::get("user_id")."',edit_at=NOW()");
		DB::update("UPDATE tax_type SET stsrc='D',edit_by='".Session::get("user_id")."',edit_at=NOW()");
		DB::insert("INSERT INTO tax_qa(tax_qa_id,parent_tax_qa_id,question,answer,priority,stsrc,edit_by,edit_at) SELECT tax_qa_id,parent_tax_qa_id,question,answer,priority,'A',".Session::get('user_id').",NOW() FROM temp_tax_qa WHERE stsrc <> 'D' ");
		DB::insert("INSERT INTO tax_qa_detail(tax_qa_id,tax_type_id,percentage,stsrc,edit_by,edit_at) SELECT tax_qa_id,tax_type_id,percentage,'A',".Session::get('user_id').",NOW() FROM temp_tax_qa_detail WHERE stsrc <> 'D' ");
		DB::insert("INSERT INTO tax_type(tax_type_id,tax_type_name,tax_type_descr,percentage,is_shown,stsrc,edit_by,edit_at) SELECT tax_type_id,tax_type_name,tax_type_descr,percentage,is_shown,'A',".Session::get('user_id').",NOW() FROM temp_tax_type WHERE stsrc <> 'D'");
	}
	public function loadTax(){
		$curr = Input::get("typeId");
		$checkLast = DB::table("temp_tax_qa_detail")
						->join("temp_tax_type","temp_tax_qa_detail.tax_type_id","=","temp_tax_type.tax_type_id")
						->select("temp_tax_qa_detail.tax_type_id","temp_tax_qa_detail.nominal","temp_tax_qa_detail.percentage","temp_tax_type.tax_type_name")
						->where("temp_tax_type.stsrc","!=","D")
						->where("temp_tax_qa_detail.stsrc","!=","D")
						->where("temp_tax_qa_detail.tax_qa_id",$curr)
						->get();
		return ["result"=>$checkLast];
	}
	public function loadTaxClient(){
		$curr = Input::get("typeId");
		DB::table("saved_qa")->insert([
			"user_id"=>Input::get("user"),
			"tax_qa_id"=>Input::get("qaId"),
			"transaction_value"=>Input::get("val"),
			"transaction_type"=>Input::get("type"),
			"submit_date"=>DB::raw("NOW()"),
			"stsrc"=>"A",
			"edit_by"=>Session::get("user_id"),
			"edit_at"=>DB::raw("NOW()")
		]);
		$checkLast = DB::table("tax_qa_detail")
						->join("tax_type","tax_qa_detail.tax_type_id","=","tax_type.tax_type_id")
						->select("tax_qa_detail.tax_type_id","tax_qa_detail.nominal","tax_qa_detail.percentage","tax_type.tax_type_name")
						->where("tax_type.stsrc","!=","D")
						->where("tax_qa_detail.stsrc","!=","D")
						->where("tax_qa_detail.tax_qa_id",$curr)
						->get();
		return ["result"=>$checkLast];
	}
}

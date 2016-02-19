<?php

namespace App\Http\Controllers;
use DB;
use Input;

class DataController extends Controller
{
	public function gender(){
		return ["result"=>DB::table("gender")
		->select("gender_id", "gender_name")
		->where("internal_use",1)
		->where("stsrc","!=","D")
		->orderBy('gender_id')->get()];
	}
	public function domicile(){
		return ["result"=>DB::table("domicile")
		->select("domicile_id", "domicile_name")
		->where("stsrc","!=","D")
		->orderBy('domicile_name')->get()];
	}
	public function role(){
		return ["result"=>DB::table("role")
		->select("role_id", "role_name")
		->where("stsrc","!=","D")
		->where("role_id",">","0")
		->orderBy('role_name')->get()];
	}
	public function tax_qa(){
		return ["result"=>DB::table("tax_qa")
		->select("tax_qa_id", "parent_tax_qa_id", "question", "answer", "priority")
		->where("stsrc","!=","D")
		->orderBy('tax_qa_id')->get()];
	}
	public function tax_qa_detail(){
		return ["result"=>DB::table("tax_qa_detail")
		->select("tax_qa_detail_id", "tax_qa_id", "tax_type_id", "percentage", "nominal")
		->where("stsrc","!=","D")
		->orderBy('tax_qa_detail_id')->get()];
	}
	public function tax_type(){
		return ["result"=>DB::table("tax_type")
		->select("tax_type_id", "tax_type_name", "tax_type_descr", "percentage")
		->where("stsrc","!=","D")
		->orderBy('tax_type_id')->get()];
	}
	public function kamuspajak(){
		$keyWord = explode(" ",Input::get("Keyword"));
		return ["result"=>DB::table("tax_type")
		->select("tax_type_id", "tax_type_name","tax_type_descr","is_shown")
		->where(function($query) use($keyWord){
			if(count($keyWord)==1 && empty($keyWord[0]))return;
			for($i=0;$i<count($keyWord);$i++){
				$query->where('tax_type_name',"like","%".$keyWord[$i]."%","or")
				->where('tax_type_descr',"like","%".$keyWord[$i]."%", "or");				
			}
		})
		->where("stsrc","!=","D")
		->orderBy('tax_type_name')->get()];
	}
}

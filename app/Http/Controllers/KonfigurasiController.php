<?php

namespace App\Http\Controllers;
use Input;
use Response;
use DB;
use Session;

class KonfigurasiController extends Controller
{
	private function convertToArray($q){
		$t = [];
		for($i=0;$i<count($q);$i++){
			array_push($t,$q[$i]->tax_qa_id);
		}
		return $t;
	}
	public function add(){
		$question = Input::get("question");
		$answer = Input::get("answer");
		$parentQuestion = Input::get("parentQuestion");
		$priority = 0;
		if(empty($question)){
			return Response::json(array(
				'error' => false,
				'message' => "Please insert a question")
			);
		}
		$c = count($answer);
		if($c<1||empty($answer[0])){
			return Response::json(array(
				'error' => false,
				'message' => "A question need at least one answer")
			);
		}
		DB::update("UPDATE temp_tax_qa_detail SET stsrc='D' WHERE tax_qa_id='".$parentQuestion."'");
		for($i=0;$i<$c;$i++){
			DB::Insert("INSERT INTO temp_tax_qa(parent_tax_qa_id,question,answer,priority,stsrc,edit_by,edit_at) VALUES(?,?,?,?,?,?,NOW())",[
				$parentQuestion,$question,$answer[$i],$priority,"A",Session::get("user_id")
			]);
		}
		return Response::json(array(
			'error' => true,
			'message' => "New question has been added"),
			200
		);
	}
	public function edit(){
		$question = Input::get("question");
		$answer = Input::get("answer");
		$parentQuestion = Input::get("parentQuestion");
		$priority = 0;
		if(empty($question)){
			return Response::json(array(
				'error' => false,
				'message' => "Please insert a question")
			);
		}
		$c = count($answer);
		for($i=0;$i<$c;$i++){
			DB::table("temp_tax_qa")
				->where("tax_qa_id",$answer[$i]["id"])
				->update([
				"parent_tax_qa_id"=>$parentQuestion,
				"question"=>$question,
				"answer"=>$answer[$i]["answer"],
				"stsrc"=>"A",
				"edit_by"=>DB::raw("NOW()"),
				"edit_at"=>DB::raw("NOW()")
			]);
		}
		return Response::json(array(
			'error' => true,
			'message' => "New question has been added"),
			200
		);
	}
	public function deleteQuestion(){
		$delNum = Input::get("delNum");
		$delete = DB::table("temp_tax_qa")->where("parent_tax_qa_id",$delNum)->update([
						'stsrc' => "D",
						'edit_by'=>Session::get("user_id"),
						'edit_at'=>DB::raw("NOW()")]);
		$searchId = DB::table("temp_tax_qa")->select("tax_qa_id")->where("parent_tax_qa_id",$delNum)->get();
		$searchId = $this->convertToArray($searchId);
		while(count(DB::table("temp_tax_qa")->select("tax_qa_id")->whereIn("parent_tax_qa_id",$searchId)->get())>0){
			$delete = DB::table("temp_tax_qa")->whereIn("parent_tax_qa_id",$searchId)->update([
							'stsrc' => "D",
							'edit_by'=>Session::get("user_id"),
							'edit_at'=>DB::raw("NOW()")]);
			$searchId = $this->convertToArray(DB::table("temp_tax_qa")->select("tax_qa_id")->whereIn("parent_tax_qa_id",$searchId)->get());
		}
		if(!$delete){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
		else{
			return Response::json(array(
				'error' => true,
				'message' => "Data has been deleted"),
				200
			);
		}
	}
	public function delete(){
		$delNum = Input::get("delNum");
		$delete = DB::table("temp_tax_qa")->where("tax_qa_id",$delNum)->update([
						'stsrc' => "D",
						'edit_by'=>Session::get("user_id"),
						'edit_at'=>DB::raw("NOW()")]);
		if(!$delete){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
		else{
			return Response::json(array(
				'error' => true,
				'message' => "Data has been deleted"),
				200
			);
		}
	}
	public function deleteDetail(){
		$delNum = Input::get("delNum");
		$delete = DB::table("temp_tax_qa_detail")->where("tax_qa_detail_id",$delNum)->update([
						'stsrc' => "D",
						'edit_by'=>Session::get("user_id"),
						'edit_at'=>DB::raw("NOW()")]);
		if(!$delete){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
		else{
			return Response::json(array(
				'error' => true,
				'message' => "Data has been deleted"),
				200
			);
		}
	}
	public function editFinish(){
		$question = Input::get("question");
		$type = Input::get("type");
		$percent = Input::get("percent");
		$nominal = Input::get("nominal");
		$insert = DB::table("temp_tax_qa_detail")
							->where("tax_qa_detail_id",Input::get("detailId"))
							->update([
								"tax_qa_id"=>$question,
								"tax_type_id"=>$type,
								"percentage"=>$percent,
								"nominal"=>$nominal,
								"stsrc"=>"A",
								"edit_by"=>Session::get("user_id"),
								"edit_at"=>DB::raw("NOW()")
							]);
		if(!$insert){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
		else{
			return Response::json(array(
				'error' => true,
				'message' => "Data has been updated"),
				200
			);
		}
	}
	public function finish(){
		$question = Input::get("question");
		$type = Input::get("type");
		$percent = Input::get("percent");
		$nominal = Input::get("nominal");
		$insert = DB::table("temp_tax_qa_detail")->insert([
								"tax_qa_id"=>$question,
								"tax_type_id"=>$type,
								"percentage"=>$percent,
								"nominal"=>$nominal,
								"stsrc"=>"A",
								"edit_by"=>Session::get("user_id"),
								"edit_at"=>DB::raw("NOW()")
							]);
		if(!$insert){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
		else{
			return Response::json(array(
				'error' => true,
				'message' => "Data has been updated"),
				200
			);
		}
	}
	public function incPriority(){
		return DB::Update("UPDATE temp_tax_qa SET priority=priority+1 WHERE tax_qa_id='".Input::get("num")."'");
	}
	public function descPriority(){
		return DB::Update("UPDATE temp_tax_qa SET priority=priority-1 WHERE tax_qa_id='".Input::get("num")."'");
	}
	public function loadRel(){
		$detail = DB::table("temp_tax_qa_detail")->select("tax_qa_detail_id","tax_type_id","percentage","nominal")->where("stsrc","A")->where("tax_qa_id",Input::get("qaID"))->get();
		$child = null;
		if(count($detail)==0){
			$child = DB::table("temp_tax_qa")->select("tax_qa_id","question","answer")->where("stsrc","A")->where("parent_tax_qa_id",Input::get("qaID"))->get();
		}
		return [
			"detail"=>$detail,
			"child"=>$child
		];
	}
}

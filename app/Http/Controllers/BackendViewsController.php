<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redirect;
use Session;
use Input;
use Route;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BackendViewsController extends Controller
{
	public function __construct(Request $request){
		$this->checkLogin($request);
	}
	public function checkLogin(Request $request){
		if(($request->path() != "admin/forgot"&&$request->path() != "admin/login") && !Session::has("user_id")){
			return Redirect::to('admin/login')->send();
		}
		return redirect('admin/pendataan');
	}
	public function login(){
		return view('pages.login');
	}
	public function forgot(){
		return view('pages.forgot');
	}
	public function pendataan(){
		return view('pages.pendataan')->with("tax",json_encode(PendataanController::get()));
	}
	public function add_pendataan(){
		return view('pages.add_pendataan');
	}
	public function edit_pendataan(){
		return view('pages.edit_pendataan');
	}
	public function view_konfigurasi(){
		$question = DB::select('select a.tax_qa_id,question,answer,a.parent_tax_qa_id, b.c parent_group,d.tax_type_name,c.tax_qa_detail_id
								from temp_tax_qa a
join (select parent_tax_qa_id,count(parent_tax_qa_id) c from temp_tax_qa where stsrc="A" group by parent_tax_qa_id) b ON a.parent_tax_qa_id = b.parent_tax_qa_id
left join temp_tax_qa_detail c ON a.tax_qa_id = c.tax_qa_id AND c.stsrc="A"
left join temp_tax_type d ON c.tax_type_id = d.tax_type_id AND d.stsrc="A"
								where a.stsrc = "A"
								order by parent_tax_qa_id ASC, priority DESC, tax_qa_id ASC');
		return view('pages.view_konfigurasi')->with("question",json_encode($question));
	}
	public function edit_konfigurasi($param = 0){
		$selected = explode(',',trim(Input::get("tes"),','));
		$listQA = DB::table("temp_tax_qa")->select("parent_tax_qa_id","tax_qa_id","question","answer","priority")->where("stsrc","A")->get();
		$selectedQA = DB::table("temp_tax_qa")->select("parent_tax_qa_id","tax_qa_id","question","answer","priority")->where("stsrc","A")->whereIn("tax_qa_id",$selected)->get();
		$selectedParent = [""];
		if(count($selectedQA)>0)
			$selectedParent = DB::table("temp_tax_qa")->select("tax_qa_id","question","answer")->where("stsrc","A")->where("tax_qa_id",$selectedQA[0]->parent_tax_qa_id)->get();
		$listType = DB::table("temp_tax_type")->select("tax_type_id","tax_type_name")->where("stsrc","A")->get();
		return view('pages.edit_konfigurasi')->with([
			"param"=>$param,
			"listQA"=>json_encode($listQA),
			"selectedQA"=>json_encode($selectedQA),
			"listType"=>json_encode($listType),
			"selectedParent"=>json_encode(count($selectedParent)>0?$selectedParent[0]:null)
			]);
	}
	public function input_simulate(){
		return view('pages.input_simulate');
	}
	public function tanya_simulate(){
		$QA = DB::table("temp_tax_qa")->select("parent_tax_qa_id","tax_qa_id","question","answer","priority")
					->where("stsrc","A")->where("parent_tax_qa_id","-1")
					->orderBy('parent_tax_qa_id','ASC')->orderBy('priority','ASC')
					->get();
		return view('pages.tanya_simulate')->with("QA",json_encode($QA));
	}
	public function calculate_simulate(){
		return view('pages.calculate_simulate');
	}
	public function question_konfigurasi(){
		$listQA = DB::table("temp_tax_qa")->select("parent_tax_qa_id","tax_qa_id","question","answer","priority")->where("stsrc","A")->where("parent_tax_qa_id",function($q){
			$q->select("parent_tax_qa_id")->from("temp_tax_qa")->first();
		})->orderBy("parent_tax_qa_id","tax_qa_id")->get();
		return view('question')->with("listQA",json_encode($listQA));
	}
	public function user(){
		return view('pages.user')->with([
		"users"=>json_encode(UserController::get()),
		"currentUser"=>Session::get("user_id")
		]);
	}
	public function add_user(){
		$profile = DB::select('select full_name,gender_id,birth_date,domicile_id from user where stsrc = ? AND user_id = ?', ["A",Session::get("user_id")]);
		$gender = DB::select('select gender_id,gender_name from gender where stsrc = ?', ["A"]);
		$domicile = DB::select('select domicile_id,domicile_name from domicile where stsrc = ?', ["A"]);
		return view('pages.add_user')->with([
			"profile"=>(empty($profile)?"":json_encode($profile[0])),
			"gender"=>json_encode($gender),
			"domicile"=>json_encode($domicile)
		]);
	}
	public function edit_user(){
		$gender = DB::select('select gender_id,gender_name from gender where stsrc = ?', ["A"]);
		$domicile = DB::select('select domicile_id,domicile_name from domicile where stsrc = ?', ["A"]);
		return view('pages.edit_user')->with([
			"gender"=>json_encode($gender),
			"domicile"=>json_encode($domicile)]);
	}
	public function rekap(){
		return view('pages.rekap');
	}
	public function profile(){
		$profile = DB::select('select full_name,gender_id,birth_date,domicile_id from user where stsrc = ? AND user_id = ?', ["A",Session::get("user_id")]);
		$gender = DB::select('select gender_id,gender_name from gender where stsrc = ?', ["A"]);
		$domicile = DB::select('select domicile_id,domicile_name from domicile where stsrc = ?', ["A"]);
		return view('pages.profile')->with([
			"profile"=>(empty($profile)?"":json_encode($profile[0])),
			"gender"=>json_encode($gender),
			"domicile"=>json_encode($domicile)
		]);
	}
	public function logout(){
		Session::flush();
		return redirect("admin/login");
	}
}

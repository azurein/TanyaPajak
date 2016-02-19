<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redirect;
use Session;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FrontendViewsController extends Controller
{
	public function __construct(Request $request){
	}
	public function home(){
		return view('pages.home');
	}
	public function kamus(){
		return view('pages.kamus');
	}
	public function tanyaPajak(){
		$QA = DB::table("tax_qa")->select("parent_tax_qa_id","tax_qa_id","question","answer","priority")
					->where("stsrc","A")->where("parent_tax_qa_id","-1")
					->orderBy('parent_tax_qa_id','ASC')->orderBy('priority','ASC')
					->get();
		$gender = DB::select('select gender_id,gender_name from gender where stsrc = ?', ["A"]);
		$domicile = DB::select('select domicile_id,domicile_name from domicile where stsrc = ?', ["A"]);
		return view('pages.tanya_pajak')->with([
			"QA"=>json_encode($QA),
			"gender"=>json_encode($gender),
			"domicile"=>json_encode($domicile)
			]);
	}
}

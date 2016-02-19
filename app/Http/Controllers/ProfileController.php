<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use Response;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function save()
    {
		$name = Input::get("name");
		$gender = Input::get("gender");
		$birth = Input::get("birth");
		$domicile = Input::get("domicile");
		$password = Input::get("pass");
		$newpassword = Input::get("newpass");
		$confirm = Input::get("confirm");
		if(empty($name)||empty($birth)){
			return Response::json(array(
				'error' => false,
				'message' => "Full name and Birth date must be filled")
			);
		}
		if(!empty($password)){
			if(empty($newpassword)||empty($confirm)){
				return Response::json(array(
					'error' => false,
					'message' => "New password and Confirm new password must be filled")
				);
			}
			$passDB = DB::select('select user_id from user where stsrc = ? AND user_id = ? AND password = ?', ["A",Session::get("user_id"),$password]);
			if(empty($passDB)){
				return Response::json(array(
					'error' => false,
					'message' => "Password must be valid")
				);
			}
			if($newpassword !== $confirm){
				return Response::json(array(
					'error' => false,
					'message' => "New password must be same with confirm new password")
				);
			}
			DB::update('update user set full_name= ?,gender_id = ?,birth_date = ?,domicile_id = ?,password = ? where stsrc = ? AND user_id = ?', [$name,$gender,$birth,$domicile,$newpassword,"A",Session::get("user_id")]);
			return Response::json(array(
				'error' => true,
				'message' => "Profile has been updated"),
				200
			);
		}
		else{
			DB::update('update user set full_name= ?,gender_id = ?,birth_date = ?,domicile_id=? where stsrc = ? AND user_id = ?', [$name,$gender,$birth,$domicile,"A",Session::get("user_id")]);
			return Response::json(array(
				'error' => true,
				'message' => "Profile has been updated"),
				200
			);
		}
    }
}
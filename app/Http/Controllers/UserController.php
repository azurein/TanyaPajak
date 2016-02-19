<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use Response;
use App\Http\Controllers\Controller;

class UserController extends Controller
{	
    public function loadUser()
    {
		$users = DB::select('select a.user_id,username,full_name,birth_date,gender_id,domicile_id
								from user a
								where a.stsrc = ?
								AND a.user_id IN('.Input::get("editId").')', ["A"]);
		return $users;
    }
	public static function get()
	{		
		$users = DB::select('select a.user_id,username,full_name,birth_date,gender_name,domicile_name,role_name,a.role_id
								from user a	
								join gender b ON a.gender_id = b.gender_id AND b.stsrc="A"
								join domicile c ON a.domicile_id = c.domicile_id AND c.stsrc="A"
								join role d ON a.role_id = d.role_id AND d.stsrc="A"							
								where a.stsrc = ?', ["A"]);
		return $users;
	}
    public function login()
    {
		$username = Input::get("username");
		$password = Input::get("password");
		if(empty($username)||empty($password)){
			return Response::json(array(
				'error' => false,
				'message' => "Username and Password must be filled")
			);
		}
		$users = DB::select('select user_id,role_id from user where stsrc = ? AND username = ? AND password = ?', ["A",$username,$password]);
		if(empty($users)){
			return Response::json(array(
				'error' => false,
				'message' => "Username and Password must be valid")
			);
		}
		if($users[0]->role_id != 0){
			return Response::json(array(
				'error' => false,
				'message' => "User must have Staff Role")
			);
		}
		$log = DB::insert('INSERT INTO user_log VALUES(?,NOW(),?,?,NOW())', [$users[0]->user_id,"A",$users[0]->user_id]);
		Session::put('user_id', $users[0]->user_id);
		Session::put('role_id', $users[0]->role_id);
        return Response::json(array('error' => true),
			200
		);
    }
    public function add()
    {
		$name = Input::get("name");
		$gender = Input::get("gender");
		$birth = Input::get("birth");
		$domicile = Input::get("domicile");
		$username = Input::get("username");
		$password = Input::get("pass");
		$confirm = Input::get("confirm");
		if(empty($name)||empty($username)||empty($birth)){
			return Response::json(array(
				'error' => false,
				'message' => "Full name ,Username and Birth date must be filled")
			);
		}
		if(empty($password)||empty($confirm)){			
			return Response::json(array(
				'error' => false,
				'message' => "Password and Confirm Password must be filled")
			);
		}
		if($password != $confirm){
			return Response::json(array(
				'error' => false,
				'message' => "Password and Confirm Password does not match")
			);
		}
		$exists = DB::select('select user_id from user where stsrc = ? AND username = ?', ["A",$username]);
		if(!empty($exists)){
			return Response::json(array(
				'error' => false,
				'message' => "User already exists")
			);
		}
		$insert = DB::insert("INSERT INTO user(username,password,full_name,gender_id,birth_date,role_id,domicile_id,stsrc,edit_by,edit_at) VALUES(?,?,?,?,?,?,?,?,?,NOW())",[$username,$password,$name,$gender,$birth,0,$domicile,"A",Session::get("user_id")]);
		if(!$insert){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
		else{
			return Response::json(array(
				'error' => true,
				'message' => "New user has been created"),
				200
			);
		}
    }
    public function guestAdd()
    {
		$name = Input::get("name");
		$gender = Input::get("gender");
		$birth = Input::get("birth");
		$domicile = Input::get("domicile");
		$username = Input::get("email");
		if(empty($name)||empty($username)||empty($birth)){
			return Response::json(array(
				'error' => false,
				'message' => "Full name ,Email and Birth date must be filled")
			);
		}
		$insertId = DB::table("user")->insertGetId([
			"username"=>$username,
			"full_name"=>$name,
			"gender_id"=>$gender,
			"birth_date"=>$birth,
			"role_id"=>1,
			"domicile_id"=>$domicile,
			"stsrc"=>"A",
			"edit_by"=>DB::raw("NOW()"),
			"edit_at"=>DB::raw("NOW()")
		]);
		$insert = DB::table("user_log")->insert([
					"user_id"=>$insertId,
					"log_time"=>DB::raw("NOW()"),
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
				'message' => "New user has been created",
				"id"=>$insertId),
				200
			);
		}
    }
    public function edit()
    {
		$name = Input::get("name");
		$gender = Input::get("gender");
		$birth = Input::get("birth");
		$domicile = Input::get("domicile");
		$username = Input::get("username");
		$password = Input::get("pass");
		$confirm = Input::get("confirm");
		if(empty($name)||empty($username)||empty($birth)){
			return Response::json(array(
				'error' => false,
				'message' => "Full name ,Username and Birth date must be filled")
			);
		}
		if(!empty($password)){
			if(empty($confirm)){
				return Response::json(array(
					'error' => false,
					'message' => "Confirm Password must be filled")
				);
			}
			if($password != $confirm){
				return Response::json(array(
					'error' => false,
					'message' => "Password and Confirm Password does not match")
				);
			}
		}
		$exists = DB::select('select user_id from user where stsrc = ? AND username = ?', ["A",$username]);
		if(empty($exists)){
			return Response::json(array(
				'error' => false,
				'message' => "User not found")
			);
		}
		if(empty($password)){
			$update = DB::update("UPDATE user SET full_name=?,gender_id=?,birth_date=?,domicile_id=?,stsrc=?,edit_by=?,edit_at=NOW() WHERE user_id=?", [$name,$gender,$birth,$domicile,"A",Session::get("user_id"),$exists[0]->user_id]);			
		}else{
			$update = DB::update("UPDATE user SET password=?,full_name=?,gender_id=?,birth_date=?,domicile_id=?,stsrc=?,edit_by=?,edit_at=NOW() WHERE user_id=?", [$password,$name,$gender,$birth,$domicile,"A",Session::get("user_id"),$exists[0]->user_id]);
		}
		if(!$update){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
        return Response::json(array('error' => true,'message' => "User has been updated"),
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
		$update = DB::update('UPDATE user SET stsrc=?,edit_by=?,edit_at=NOW() WHERE user_id IN('.join(",",$list).')', ["D",Session::get("user_id")]);
		if(!$update){
			return Response::json(array(
				'error' => false,
				'message' => "An unknown error has occurred")
			);
		}
        return Response::json(array('error' => true,'message' => "User has been deleted"),
			200
		);
    }
}
<?php

namespace App\Http\Controllers;

use Mail;
use DB;
use Input;
use Str;

class ForgotController extends Controller
{
	public function send_email(){
		$email = Input::get("email");
		$newPass = str_random(6);
		DB::table("user")->where("username",$email)->update(["password"=>$newPass]);
		Mail::send([], [], function ($m) use ($email,$newPass) {
            $m->from('silvranz@gmail.com', 'silvranz');

            $m->to($email, "user")->subject('Password')->setBody($newPass);
		});
		return redirect('admin');
	}
}

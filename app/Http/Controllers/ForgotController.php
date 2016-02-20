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
		$mailBody = "
					Yth. User Tanya Pajak,

					Password username Anda: ".$email.", sudah kami ubah menjadi: ".$newPass."
					Segera ubah password Anda pada Menu Profile.


					Salam,
					Tanya Pajak
					";
		DB::table("user")->where("username",$email)->update(["password"=>$newPass]);
		Mail::send([], [], function ($m) use ($email,$mailBody) {
            $m->from('silvranz@gmail.com', 'silvranz');

            $m->to($email, "user")->subject('Password')->setBody($mailBody);
		});
		return redirect('admin');
	}
}

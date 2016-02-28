<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get("/","FrontendViewsController@home");
Route::get("home","FrontendViewsController@home");
Route::get("kamus","FrontendViewsController@kamus");
Route::get("tanya","FrontendViewsController@tanyaPajak");

Route::group(array('prefix' => 'admin', 'before' => 'auth.basic'), function()
{	
	Route::get("/","BackendViewsController@pendataan");
	Route::get("login","BackendViewsController@login");
	Route::get("forgot","BackendViewsController@forgot");
	Route::group(array('prefix' => 'pendataan', 'before' => 'auth.basic'), function()
	{	
		Route::get("/","BackendViewsController@pendataan");
		Route::get("add","BackendViewsController@add_pendataan");
		Route::get("edit","BackendViewsController@edit_pendataan");
		Route::get("edit/{id}","BackendViewsController@edit_pendataan");
	});
	Route::group(array('prefix' => 'konfigurasi', 'before' => 'auth.basic'), function()
	{	
		Route::get("/","BackendViewsController@view_konfigurasi");
		Route::get("view","BackendViewsController@view_konfigurasi");
		Route::get("edit","BackendViewsController@edit_konfigurasi");
		Route::get("edit/{param}","BackendViewsController@edit_konfigurasi");
		Route::group(array('prefix' => 'simulate', 'before' => 'auth.basic'), function()
		{	
			Route::get("/","BackendViewsController@input_simulate");
			Route::get("tanya","BackendViewsController@tanya_simulate");
			Route::get("tanya/{lastId}","BackendViewsController@tanya_simulate");
			Route::get("calculate","BackendViewsController@calculate_simulate");
			Route::get("calculate/{lastId}","BackendViewsController@calculate_simulate");
		});
		Route::get("question","BackendViewsController@question_konfigurasi");
	});
	Route::group(array('prefix' => 'user', 'before' => 'auth.basic'), function()
	{	
		Route::get("/","BackendViewsController@user");
		Route::get("add","BackendViewsController@add_user");
		Route::get("edit","BackendViewsController@edit_user");
		Route::get("edit/{id}","BackendViewsController@edit_user");
	});
	Route::get("rekap","BackendViewsController@rekap");
	Route::get("profile","BackendViewsController@profile");
	Route::get("logout","BackendViewsController@logout");
});
Route::group(array('prefix' => 'api', 'before' => 'auth.basic'), function()
{	
	Route::post("simulasi/backSimulate","SimulateController@backSimulate");
	Route::post("simulasi/nextSimulate","SimulateController@nextSimulate");
	Route::post("simulasi/back","SimulateController@back");
	Route::post("simulasi/next","SimulateController@next");
	Route::post("simulasi/loadTax","SimulateController@loadTax");
	Route::post("simulasi/loadTaxClient","SimulateController@loadTaxClient");
	Route::post("simulasi/publish","SimulateController@publish");
	Route::get("data/version","DataController@version");
	Route::get("data/role","DataController@role");
	Route::get("data/searchRole","DataController@searchRole");
	Route::get("data/tax_qa","DataController@tax_qa");
	Route::get("data/tax_qa_detail","DataController@tax_qa_detail");
	Route::get("data/tax_type","DataController@tax_type");
	Route::get("data/gender","DataController@gender");
	Route::get("data/domicile","DataController@domicile");
	Route::get("data/kamuspajak","DataController@kamuspajak");
	Route::post("profile/save","ProfileController@save");
	Route::get("pendataan/get","PendataanController@get");
	Route::post("pendataan/add","PendataanController@add");
	Route::post("pendataan/edit","PendataanController@edit");
	Route::post("pendataan/loadType","PendataanController@loadType");
	Route::post("pendataan/delete","PendataanController@delete");
	Route::get('user/get', 'UserController@get');
	Route::post('user/login', 'UserController@login');
	Route::post('user/add', 'UserController@add');
	Route::post('user/guestAdd', 'UserController@guestAdd');
	Route::post('user/loadUser', 'UserController@loadUser');
	Route::post('user/edit', 'UserController@edit');
	Route::post('user/delete', 'UserController@delete');
	Route::post('konfigurasi/delQ', 'KonfigurasiController@delQ');
	Route::post('konfigurasi/delType', 'KonfigurasiController@delType');
	Route::post('konfigurasi/add', 'KonfigurasiController@add');
	Route::post('konfigurasi/edit', 'KonfigurasiController@edit');
	Route::post('konfigurasi/delQuestion', 'KonfigurasiController@deleteQuestion');
	Route::post('konfigurasi/del', 'KonfigurasiController@delete');
	Route::post('konfigurasi/delDetail', 'KonfigurasiController@deleteDetail');
	Route::post('konfigurasi/finish', 'KonfigurasiController@finish');
	Route::post('konfigurasi/editFinish', 'KonfigurasiController@editFinish');
	Route::post('konfigurasi/incPriority', 'KonfigurasiController@incPriority');
	Route::post('konfigurasi/descPriority', 'KonfigurasiController@descPriority');
	Route::post('konfigurasi/loadRel', 'KonfigurasiController@loadRel');
	Route::post('rekap', 'RekapController@get_user');
	Route::post('forgot', 'ForgotController@send_email');
});
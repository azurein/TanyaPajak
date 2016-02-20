@extends("contentTemplate")
@extends("script/editUserScript")

@section("mainContent")
<div class="page-header">
	<h3>Edit User</h3>
</div>
<div id="formContainer"></div>
<form id="formTemplate" class="hide itemForm" style="background-color:#DDD;padding:15px;margin-bottom:15px">
	<div class="form-group">
		<label>Full Name</label>
		<input id="nameTxt" type="email" class="form-control" placeholder="">
	</div>
	<div class="form-group">
		<label>Gender</label>
		<select class="form-control" id="genderList"></select>
	</div>
	<div class="form-group">
		<label for="exampleInputFile">Birth Date</label>
		<div class="input-group">
			<input id="birthTxt" type="text" class="form-control datepicker" aria-describedby="basic-addon1" placeholder="DD MMM YYYY">
			<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
		</div>
	</div>
	<div class="form-group">
		<label>Domicile</label>
		<select class="form-control" id="domicileList"></select>
	</div>
	<div class="form-group">
		<label>Username (email)</label>
		<input id="usernameTxt" type="email" class="form-control" placeholder="" disabled>
	</div>
	<div class="form-group">
		<label>Password</label>
		<input id="passTxt" type="password" class="form-control" placeholder="">
	</div>
	<div class="form-group">
		<label>Confirm Password</label>
		<input id="confirmpassTxt" type="password" class="form-control" placeholder="">
	</div>
	<div class="alert alert-success hide" id="successMessage"></div>
	<div class="alert alert-danger hide" id="warningMessage"></div>
</form>
<div class="form-group">
	<button type="button" class="btn btn-default" onclick="location.href='{{ URL::to('admin/user') }}';">Back</button>
	<button type="button" class="btn btn-default" onclick="editUser();">Save</button>
</div>
@stop
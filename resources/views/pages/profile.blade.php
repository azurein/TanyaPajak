@extends("contentTemplate")
@extends("script/profileScript")

@section("mainContent")
<div class="page-header">
	<h3>Profile</h3>
</div>
<form>
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
		<label>Old Password</label>
		<input id="passTxt" type="password" class="form-control" placeholder="">
	</div>
	<div class="form-group">
		<label>New Password</label>
		<input id="newpassTxt" type="password" class="form-control" placeholder="">
	</div>
	<div class="form-group">
		<label>Confirm New Password</label>
		<input id="confirmpassTxt" type="password" class="form-control" placeholder="">
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-default" id="saveBtn">Save</button>
	</div>
</form>
<div class="alert alert-success hide" id="successMessage"></div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
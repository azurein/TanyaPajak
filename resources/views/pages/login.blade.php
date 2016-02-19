@extends("template")
@extends("loginHeader")
@extends("script/loginScript")

@section("content")
<div class="col-md-3">
</div>
<div class="col-md-6">
	<div class="page-header">
		<h3>Tanya Pajak - Staff Login</h3>
	</div>
	<form role="form">
		<div class="form-group">
			 
			<label for="exampleInputEmail1">
				Username
			</label>
			<input type="text" class="form-control" id="exampleInputEmail1" />
		</div>
		<div class="form-group">
			 
			<label for="exampleInputPassword1">
				Password
			</label>
			<input type="password" class="form-control" id="exampleInputPassword1" />
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-default" value="Log In" />
			<span>&nbsp;&nbsp;</span>
			<a href="{{ URL::to('/admin/forgot') }}">Forgot Password?</a>
		</div>
	</form>
	<div class="alert alert-danger hide" id="warningMessage"></div>
</div>
<div class="col-md-3">
</div>
@stop

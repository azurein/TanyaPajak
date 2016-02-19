@extends("template")
@extends("loginHeader")

@section("content")
<div class="row">
<div class="col-md-3">
</div>
<div class="col-md-6">
	<div class="page-header">
		<h3>Forgot Password</h3>
	</div>
	<form role="form" method="post" action="{{ URL::to('/api/forgot') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-group">
			 
			<label for="exampleInputEmail1">
				Input your Username (email)
			</label>
			<input type="email" name="email" class="form-control" id="exampleInputEmail1" />
		</div>
		<button type="button" onclick="location.href='{{ URL::to('/admin') }}';" class="btn btn-default">Back</button>
		<input type="submit" class="btn btn-default" value="Send Link to Reset Password" />
	</form>
</div>
<div class="col-md-3">
</div>
</div>
@stop

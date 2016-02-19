@extends("contentTemplate")
@extends("script/addPendataanScript")

@section("mainContent")
<div class="page-header">
	<h3>Add Jenis Pajak</h3>
</div>
<form>
	<div class="form-group">
		<label>Tax Type</label>
		<input name="type" type="email" class="form-control" placeholder="">
	</div>
	<div class="form-group">
		<label>Description</label>
		<textarea name="desc" class="form-control" rows="5" id="comment"></textarea>
	</div>
	<div class="form-group">
		<label>Tax %</label>
		<input name="percent" type="email" class="form-control" placeholder="">
	</div>
	<div class="form-group">
		<label class="checkbox-inline"><input name="shown" type="checkbox" value="1">Shown in Dictionary?</label>
	</div>		
	<div class="form-group">
		<button type="button" class="btn btn-default" onclick="location.href='{{ URL::to('/admin/pendataan') }}';">Back</button>
		<button type="button" class="btn btn-default" onclick="addPendataan();">Save</button>
	</div>
</form>	
<div class="alert alert-success hide" id="successMessage"></div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
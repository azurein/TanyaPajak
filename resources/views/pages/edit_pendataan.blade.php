@extends("contentTemplate")
@extends("script/editPendataanScript")

@section("mainContent")
<div class="page-header">
	<h3>Edit Jenis Pajak</h3>
</div>
<div id="formContainer"></div>
<form id="formTemplate" class="hide itemForm" style="background-color:#DDD;padding:15px;margin-bottom:15px">
	<div class="form-group">
		<label>Tax Type</label>
		<input name="type" type="email" class="form-control" placeholder="" disabled>
	</div>
	<div class="form-group">
		<label>Description</label>
		<textarea name="desc" class="form-control" rows="5" id="comment"></textarea>
	</div>
	<div class="form-group">
		<label>Tax %</label>
		<input name="percent" type="text" class="form-control" placeholder="" />
	</div>
	<div class="form-group">
		<label class="checkbox-inline"><input name="shown" type="checkbox" value="">Shown in Dictionary?</label>
	</div><br>
</form>

<div class="form-group">
	<button type="button" class="btn btn-default" onclick="location.href='{{ URL::to('/admin/pendataan') }}';">Back</button>
	<button type="button" class="btn btn-default" onclick="editPendataan();">Save</button>
</div>
<div class="alert alert-success hide" id="successMessage"></div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
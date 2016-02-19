@extends("configurationTab")
@extends("script/viewKonfigurasiScript")

@section("configurationContent")
<style>
	#ctxCnt li:hover{
		background-color:#EEE;
	}
</style>
<div id="ctxCnt" style="display:none;position:fixed">
	<ul class="list-group">
		<li class="list-group-item" id="incPriority" style="cursor:pointer"><span class="badge">^</span> Increase Priority</li>
		<li class="list-group-item" id="decPriority" style="cursor:pointer"><span class="badge">v</span> Decrease Priority</li>
	</ul>
</div>
<div class="form-group schema">
	<div class="alert alert-danger hide" id="warningMessage"></div>
	<svg width="100%" height="100%" preserveAspectRatio="none" id="relationContainer">
		Sorry, your browser does not support inline SVG.
	</svg><br>
	<div class="form-inline">
		<div class="form-group" style="padding-right:10px;">
			<button type="button" class="btn btn-default" onclick="location.href='{{ URL::to('admin/konfigurasi/edit/0') }}';">Add</button>
		</div>
		<div class="form-group" style="padding-right:10px;">
			<button type="button" class="btn btn-default" id="editKonfig">Edit</button>
		</div>
		<div class="form-group" style="">
			<button type="button" class="btn btn-default" id="delKonfig">Delete</button>
		</div>
		<div class="form-group" style="padding-left:10px;">
			<button type="button" class="btn btn-default" onclick="location.href='{{ URL::to('admin/konfigurasi/simulate') }}';">Simulate</button>
		</div>
	</div><br><br>
</div>
@stop
@extends("simulateTemplate")
@extends("script/tanyaSimulateScript")

@section("mainContent")
<div class="page-header">
	<h4 id="questionText"></h4>
</div>
<div class="form-group">
	<div class="input-group">
		<div class="list-group" id="answerList">
		</div>
	</div>						
	<div class="input-group">							
		<div class="login-side"><button id="prevBtn" type="button" class="btn btn-primary">Sebelumnya</button></div>
		<button id="nextBtn" type="button" class="btn btn-primary">Selanjutnya</button>
	</div>
</div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
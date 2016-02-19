@extends("simulateTemplate")
@extends("script/inputSimulateScript")

@section("mainContent")
<div class="page-header">
	<h4>Data Transaksi</h4>
</div>
<div class="form-group">
	<div class="input-group">
		<label>Jenis Transaksi</label>
		<input id="transactionType" type="email" class="form-control" placeholder="">
	</div>			
	<div class="input-group">
		<label>Jumlah Transaksi</label>
		<input id="totalTransaction" type="email" class="form-control" placeholder="">
	</div>						
	<div class="input-group">
		<div class="login-side"><button onclick="location.href='{{URL::to('admin/konfigurasi')}}';" type="button" class="btn btn-primary">Sebelumnya</button></div>
		<button id="startSimulate" type="button" class="btn btn-primary">Selanjutnya</button>
	</div>
</div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
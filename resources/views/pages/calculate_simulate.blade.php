@extends("simulateTemplate")
@extends("script/calculateSimulateScript")

@section("mainContent")
<div class="page-header">
	<h4>Perhitungan Pajak</h4>
</div>
<div class="form-group">
	<div class="input-group col-md-6">
		<h5 class="col-md-6">Jenis Transaksi</h5>
		<h5 class="col-md-6" id="transactionType"></h5>
		<h5 class="col-md-6">Total Transaksi</h5>
		<h5 class="col-md-6" id="transactionTotal"></h5>
		<div id="taxContainer">
		</div>
		<div id="totalContainer" style="clear:both">
			<h4 style="margin:0" class="col-md-5">Total Pajak</h4>
			<h3 style="margin:0" class=" col-md-7" id="total">Rp 170,000.-</h3>
		</div>
	</div>						
	<div class="input-group">							
		<div class="login-side"><button id="backButton" type="button" class="btn btn-primary">Sebelumnya</button></div>
		<button type="button" class="btn btn-primary" id="publishBtn">Publish</button>
		<button  style="margin-right: 45px;" onclick="location.href='{{URL::to('admin/konfigurasi/simulate')}}';" type="button" class="btn btn-primary">Ulangi</button>

	</div>
</div>
<div class="alert alert-success hide" id="successMessage"></div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
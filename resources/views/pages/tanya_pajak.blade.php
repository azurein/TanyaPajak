@extends("frontendTemplate")
@extends("frontendHeader")
@extends("script/tanyaScript")
@section("content")
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-5"><br>
			<div class="container container-table">
				<div class="row vertical-center-row" style="margin: 0; border: none;">
					<form id="profileForm">
						<div class="page-header" style="border: none; padding-bottom: 0px;">
							<h4 >Data Diri</h4>
						</div>
						<div class="form-group">
							<div class="input-group">
								<label>Email</label>
								<input id="emailProfile" type="email" class="form-control" placeholder="">
							</div>
							<div class="input-group">
								<label>Nama Lengkap</label>
								<input id="nameProfile" type="email" class="form-control" placeholder="">
							</div>
							<div class="input-group">
								<label>Gender</label>
								<select id="genderProfile" class="form-control" id="sel1"></select>
							</div>
							<div class="input-group">
								<label for="exampleInputFile">Tanggal Lahir</label>
								<div class="input-group">
									<input id="dateBirthProfile" type="text" class="form-control datepicker" aria-describedby="basic-addon1" placeholder="DD MMM YYYY">
									<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>Domisili (kotamadya)</label>
								<select id="domicileProfile" class="form-control" id="sel1"></select>
							</div>
							<div class="input-group">				
								<div class="login-side" style="padding-top: 8px;"><label class="checkbox-inline" style="line-height: 22px;"><input id="saveOpt" type="checkbox">Simpan Data Diri</label></div>		
								<button id="resetBtn" style="margin-left: 10px;"type="button" class="btn btn-primary">Reset</button>	
								<button id="nextProfileBtn" type="button" class="btn btn-primary">Selanjutnya</button>
							</div>
						</div>
					</form>
					<form id="roleForm" class="hide">
						<div class="page-header" style="border: none; padding-bottom: 0px;">
							<h4 style="text-align: left;">Data Pekerjaan</h4>
						</div>
						<div class="input-group">
								<input type="text" class="form-control" aria-describedby="basic-addon1" placeholder="Masukkan kata pencarian...">
								<span class="input-group-addon" style="cursor:pointer" id="searchButton"><i class="fa fa-search"></i></span>
						</div>
						<div class="input-group">
							<div class="list-group" id="roleList">
							</div>
						</div>
					</form>
					<form id="transactionForm" class="hide">
						<div class="page-header" style="border: none; padding-bottom: 0px;">
							<h4>Data Transaksi</h4>
						</div>
						<div class="form-group">
							<div class="input-group">
								<label>Jenis Transaksi</label>
								<input id="transactionName" type="email" class="form-control" placeholder="">
							</div>		
							<div class="input-group">
								<label>Jumlah Transaksi</label>
								<input id="totalTransaction" type="email" class="form-control" placeholder="">
							</div>						
							<div class="input-group">							
								<div class="login-side"><button id="backTransactionBtn" type="button" class="btn btn-primary">Sebelumnya</button></div>
								<button id="nextTransactionBtn" type="button" class="btn btn-primary">Selanjutnya</button>
							</div>
						</div>
					</form>					
					<form id="questionForm" class="hide">
						<div class="page-header">
							<h4 id="questionText"></h4>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="list-group" id="answerList">
								</div>
							</div>
						</div>
					</form>
					<form id="calculateForm" class="hide">
						<div class="page-header">
							<h4>Perhitungan Pajak</h4>
						</div>
						<div class="form-group">
							<div class="input-group">
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
								<div class="login-side"><button id="backCalculate" type="button" class="btn btn-primary">Sebelumnya</button></div>
								<button  style="margin-right: 45px;"  id="resetCalculate" type="button" class="btn btn-primary">Ulangi</button>

							</div>
						</div>
					</form>
					<div class="alert alert-danger hide" id="warningMessage"></div>
				</div>
			</div>
		</div>
		<div class="col-md-5"><br><br><br>
			<div class="container-table">
				<div class="row vertical-center-row" style="margin: 0; border: none;">
					<ol>
						<a class="linknow" con="profileForm"><li>Pengisian Data Diri</li></a>
						<a id="linknext" con="roleForm"><li>Pilih Pekerjaan</li></a>
						<a id="linknext" con="transactionForm"><li>Pengisian Data Transaksi</li></a>
						<a id="linknext" con="questionForm"><li>Tanya Jawab Pajak</li></a>
						<a id="linknext" con="calculateForm"><li>Kalkulasi Pajak</li></a>
					</ol>
				</div>	
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
@stop
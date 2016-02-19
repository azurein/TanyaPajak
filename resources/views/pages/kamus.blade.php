@extends("frontendTemplate")
@extends("frontendHeader")
@extends("script/kamusScript")
@section("content")
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10"><br>
			<div class="container container-table">
				<div class="row vertical-center-row" id="searchContainer" style="margin: 0; border: none;">
					<br>
					<div class="page-header" style="border: none; padding-bottom: 0px;">
						<h4 style="text-align: left;">Kamus Jenis Pajak</h4>
					</div>
					<form>
					<div class="input-group">
							<input type="text" class="form-control" aria-describedby="basic-addon1" placeholder="Masukkan kata pencarian...">
							<span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
					</div>
					</form>
				</div>	
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
@stop
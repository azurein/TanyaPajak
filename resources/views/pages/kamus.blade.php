@extends("frontendTemplate")
@extends("frontendHeader")
@extends("script/kamusScript")
@section("content")
<div class="container-fluid">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10"><br>
			<div class="container container-table">
				<div id="searchContainer" style="border: none;">
					<br>
					<form>
					<div class="input-group">
							<input type="text" class="form-control" aria-describedby="basic-addon1" placeholder="Masukkan kata pencarian...">
							<span class="input-group-addon" style="cursor:pointer" id="searchButton"><i class="fa fa-search"></i></span>
					</div>
					</form>
				</div>	
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
@stop
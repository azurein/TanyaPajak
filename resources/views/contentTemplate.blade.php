@extends("template")
@extends("header")

@section("content")
<script>
	$(document).ready(function(){
		var className = "{{Request::segment(2)}}";
		if(!className){
			className = "pendataan";
		}
		$("."+className).addClass("active");
	})
</script>
<div class="row row-offcanvas row-offcanvas-left">

	<!-- sidebar -->
	<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
		<ul class="nav">
			<li class="pendataan"><a href="{{ URL::to('admin/pendataan') }}">Pendataan Jenis Pajak</a></li>
			<li class="konfigurasi"><a href="{{ URL::to('/admin/konfigurasi') }}">Konfigurasi Jenis Pajak</a></li>
			<li class="user"><a href="{{ URL::to('/admin/user') }}">User Management</a></li>
			<li class="rekap"><a href="{{ URL::to('/admin/rekap') }}">Rekap Jumlah Pengguna</a></li>
			<li class="profile"><a href="{{ URL::to('/admin/profile') }}">Profile</a></li>
			<li class="logout"><a href="{{ URL::to('/admin/logout') }}">Log Out</a></li>               
		</ul>
	</div>

	<div class="row">
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
			@yield("mainContent")
		</div>
		<div class="col-md-2">
		</div>
	</div>
</div>	
@stop
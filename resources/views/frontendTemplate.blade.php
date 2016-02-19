<!DOCTYPE html>
<html lang="en">
	<title>Tanya Pajak</title>
	<link rel="stylesheet" href="{{ URL::to('frontend') }}/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ URL::to('frontend') }}/css/custom.css">
	<link rel="stylesheet" href="{{ URL::to('frontend') }}/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::to('frontend') }}/css/bootstrap-social.css">
	<link rel="stylesheet" href="{{ URL::to('frontend') }}/css/datepicker.css">
	<script src="{{ URL::to('frontend') }}/js/jquery-1.11.3.min.js"></script>
	<script src="{{ URL::to('frontend') }}/js/bootstrap.min.js"></script>
	<script src="{{ URL::to('frontend') }}/js/bootstrap-datepicker.js"></script>
	@yield("script")
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<body>

		<div class="container-fluid">
			@yield("menu")
	        @yield("content")
		    <footer>
		        <div class="container">
		            <div class="row"><center>
		                <div class="col-lg-12">
		                    <ul class="list-inline">
		                        <li>
		                            <a href="{{URL::to('/')}}">Fitur Kami</a>
		                        </li>
		                        <li class="footer-menu-divider">&sdot;</li>
		                        <li>
		                            <a href="{{URL::to('/tanya')}}">Tanya-Jawab Pajak</a>
		                        </li>
		                        <li class="footer-menu-divider">&sdot;</li>
		                        <li>
		                            <a href="{{URL::to('/kamus')}}">Kamus Jenis Pajak</a>
		                        </li>
		                    </ul>
		                    <p class="copyright text-muted small">Copyright &copy; Your Company 2014. All Rights Reserved</p>
		                </div></center>
		            </div>
		        </div>
		    </footer>
		    
		</div>

	</body>

</html>
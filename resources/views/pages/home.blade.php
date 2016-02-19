@extends("frontendTemplate")
@section("content")
<div class="row" style="margin-bottom: -30px;">
	<div class="col-md-12">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
				</button><a class="navbar-brand" href="{{URL::to('/')}}">TanyaPajak.org</a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{URL::to('/')}}#fiturkami">Fitur Kami</a></li>
					<li><a href="{{URL::to('/')}}/tanya">Tanya-Jawab Pajak</a></li>
					<li><a href="{{URL::to('/')}}/kamus">Kamus Jenis Pajak</a></li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="jumbotron">
		<h1>Selamat Datang di TanyaPajak.org</h1>
		<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."</p>
		<br>
		<button onclick="location.href='{{URL::to('tanya')}}'" type="button" class="btn btn-primary btn-lg" style="float: none;">Mulai Tanya Pajak
		</button>
	</div>
</div>

<div id="#fiturkami" class="row containerfitur" style="border-top: solid 5px #0C9900;">	
	<h2 class="subpage">Fitur Kami</h2>
	<div class="col-sm-1"></div>
	<div class="col-sm-5">
		<center><span class="fa-stack fa-5x">
			<i class="fa fa-circle fa-stack-2x" id="fontfiturback"></i>
			<i class="fa fa-comments fa-stack-1x fa-inverse" id="fontfiturfront"></i>
		</span></center>
		<h4 class="subpage">Tanya Jawab Langsung</h4>
		<p class="subpage">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	</div>
	<div class="col-sm-5">
	   <center><span class="fa-stack fa-5x">
			<i class="fa fa-circle fa-stack-2x" id="fontfiturback"></i>
			<i class="fa fa-check fa-stack-1x fa-inverse" id="fontfiturfront"></i>
		</span></center>
		<h4 class="subpage">Regulasi Pajak Nasional</h4>
		<p class="subpage">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	</div>
	<div class="col-sm-1"></div>
</div>
<div class="row containerfitur">	
	<br><br>
	<div class="col-sm-1"></div>
	<div class="col-sm-5">
		<center><span class="fa-stack fa-5x">
			<i class="fa fa-circle fa-stack-2x" id="fontfiturback"></i>
			<i class="fa fa-book fa-stack-1x fa-inverse" id="fontfiturfront"></i>
		</span></center>
		<h4 class="subpage">Kamus Jenis Pajak</h4>
		<p class="subpage">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	</div>
	<div class="col-sm-5">
	   <center><span class="fa-stack fa-5x">
			<i class="fa fa-circle fa-stack-2x" id="fontfiturback"></i>
			<i class="fa fa-cogs fa-stack-1x fa-inverse" id="fontfiturfront"></i>
		</span></center>
		<h4 class="subpage">Kalkulasi Pajak</h4>
		<p class="subpage">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
		<div class="col-sm-1"></div><br><br><br>
	</div>
</div>
@stop
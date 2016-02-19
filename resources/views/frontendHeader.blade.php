@section("menu")
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
</div>
@stop
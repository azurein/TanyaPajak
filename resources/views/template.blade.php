<!DOCTYPE html>
<html>
    <head>
        <title>Tanya Pajak</title>
		
	    <link href="{{ URL::to('backend') }}/css/style.css" rel="stylesheet">
	    <link href="{{ URL::to('backend') }}/css/bootstrap.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="{{ URL::to('backend') }}/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ URL::to('backend') }}/css/bootstrap-social.css">
		<link rel="stylesheet" href="{{ URL::to('backend') }}/css/datepicker.css">
		
		<script src="{{ URL::to('backend') }}/js/jquery.min.js"></script>
		<script src="{{ URL::to('backend') }}/js/bootstrap.min.js"></script>
		<script src="{{ URL::to('backend') }}/js/bootstrap-datepicker.js"></script>
		<script src="{{ URL::to('backend') }}/js/scripts.js"></script>
		@yield("script")
    </head>
    <body>
		<div class="container-fluid">
			<div class="header">
				@yield("header")
			</div>
			<div class="container">
				@yield("content")
			</div>
        </div>
    </body>
</html>

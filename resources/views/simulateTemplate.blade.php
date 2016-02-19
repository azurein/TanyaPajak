<!DOCTYPE html>
<html lang="en">
	<title>Tanya Pajak</title>

	<link rel="stylesheet" href="{{ URL::to('backend/simulate') }}/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ URL::to('backend/simulate') }}/css/custom.css">
	<link rel="stylesheet" href="{{ URL::to('backend/simulate') }}/css/bootstrap.theme.min.css">
	<link rel="stylesheet" href="{{ URL::to('backend/simulate') }}/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::to('backend/simulate') }}/css/bootstrap-social.css">
	<script src="{{ URL::to('backend/simulate') }}/js/jquery-1.11.3.min.js"></script>
	<script src="{{ URL::to('backend/simulate') }}/js/bootstrap.min.js"></script>
	@yield("script")
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<body>

		<div class="container container-table">
		    <div class="row vertical-center-row">
				<form>
					@yield("mainContent")
				</form>
			</div>	
		</div>

	</body>

</html>
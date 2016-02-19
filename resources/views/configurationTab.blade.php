@extends("contentTemplate")

@section("mainContent")
<script>
	$(document).ready(function(){
		if("{{Request::segment(3)}}" == "edit"){			
			$(".edit").addClass("active");
		}
		else{			
			$(".view").addClass("active");
		}
	})
</script>
<ul class="nav nav-tabs">
  <li class="view"><a href="{{ URL::to('admin/konfigurasi/view') }}">View Relation</a></li>
  <li class="edit"><a href="{{ URL::to('admin/konfigurasi/edit') }}">Manage Question-Answer</a></li>
</ul>
<form>
	@yield("configurationContent")
</form>
@stop
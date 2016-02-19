@section("script")
<script>
	$(document).ready(function(){
		$("#startSimulate").click(function(e){
			e.preventDefault();
			var type = $("#transactionType").val();
			var total = $("#totalTransaction").val();
			if(type==""||total==""){
				$("#warningMessage").removeClass("hide").text("Please Input transaction type and total transaction");
				return;
			}
			else if(isNaN(parseInt(total)) || !isFinite(total)){
				$("#warningMessage").removeClass("hide").text("Total transaction must be a number");
				return;
			}
			document.cookie = "tname="+type;
			document.cookie = "total="+total;
			location.href = "{{URL::to('admin/konfigurasi/simulate/tanya')}}";
		})
	})
</script>
@stop
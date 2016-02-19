@section("script")
<script>
		function addPendataan(){
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('/api/pendataan/add') }}",
				data:{
						type:$("form [name='type']").val(),
						desc:$("form [name='desc']").val(),
						percent:$("form [name='percent']").val(),
						shown:$("form [name='shown']").prop("checked")?"1":"0"
					},
				type:"POST",
				success:function(data){
					if(data.error){
						$("#warningMessage").addClass("hide");
						$("#successMessage").text(data.message).removeClass("hide");
					}
					else{
						$("#successMessage").addClass("hide");
						$("#warningMessage").text(data.message).removeClass("hide");
					}
				}
			});
		}
	</script>
@stop
@section("script")
<script>
	$(document).ready(function(){
		var typeId = location.hash.split("#")[1].split(",");
		$.ajax({
			headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
			url:"{{ URL::to('/api/pendataan/loadType') }}",
			data:{editId:typeId.join()},
			type:"POST",
			success:function(data){
				for(var i=0;i<data.length;i++){
					var newForm = $("#formTemplate").clone().removeAttr("id").removeClass("hide");					
					$("[name='type']",newForm).val(data[i].tax_type_name);
					$("[name='desc']",newForm).val(data[i].tax_type_descr);
					$("[name='percent']",newForm).val(data[i].percentage);
					$("[name='shown']",newForm).prop("checked",data[i].is_shown ==1?true:false);
					$("#formContainer").append(newForm);
				}
			}
		})
	})
	function editPendataan(){
		$(".itemForm:visible").each(function(){
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('/api/pendataan/edit') }}",
				data:{
						type:$("[name='type']",this).val(),
						desc:$("[name='desc']",this).val(),
						tax:$("[name='percent']",this).val(),
						shown:$("[name='shown']",this).prop("checked")?"1":"0"
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
			})
			
		})
	}
</script>
@stop
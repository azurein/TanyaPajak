@section("script")
<script>
	$(document).ready(function(){		
		var gender = {!! $gender !!};
		var domicile = {!! $domicile !!};
		for(var i=0;i<gender.length;i++){
			$("#genderList").append($("<option value='"+gender[i].gender_id+"'>"+gender[i].gender_name+"</option>"));
		}
		for(var i=0;i<domicile.length;i++){
			$("#domicileList").append($("<option value='"+domicile[i].domicile_id+"'>"+domicile[i].domicile_name+"</option>"));
		}
		var selectedId = location.href.split("#")[1].split(",");		
		$.ajax({
			headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
			url:"{{ URL::to('/api/user/loadUser') }}",
			data:{editId:selectedId.join()},
			type:"POST",
			success:function(data){
				for(var i=0;i<data.length;i++){
					var newForm = $("#formTemplate").clone().removeAttr("id").removeClass("hide");					
					$("#nameTxt",newForm).val(data[i].full_name);
					$("#genderList",newForm).val(data[i].gender_id);
					$("#birthTxt",newForm).val(data[i].birth_date).datepicker({
						format: 'yyyy-mm-dd',
						defaultViewDate:data[i].birth_date
					});
					$("#domicileList",newForm).val(data[i].domicile_id);
					$("#usernameTxt",newForm).val(data[i].username);
					$("#formContainer").append(newForm);
				}
			}
		})
	})
	
	function editUser(){
		$(".itemForm:visible").each(function(){
			var data = {
				name:$("#nameTxt",this).val(),
				gender:$("#genderList",this).val(),
				birth:$("#birthTxt",this).val(),
				domicile:$("#domicileList",this).val(),
				username:$("#usernameTxt",this).val(),
				pass:$("#passTxt",this).val(),
				confirm:$("#confirmpassTxt",this).val()
			};
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('/api/user/edit') }}",
				data:data,
				source:this,
				type:"POST",
				success:function(data){
					if(data.error){
						$("#warningMessage",this.source).addClass("hide");
						$("#successMessage",this.source).text(data.message).removeClass("hide");
					}
					else{
						$("#successMessage",this.source).addClass("hide");
						$("#warningMessage",this.source).text(data.message).removeClass("hide");
					}
				}
			})
		})
	}
</script>
@stop
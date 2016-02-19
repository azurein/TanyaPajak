@section("script")
<script>
	$(document).ready(function(){
		var gender = {!! $gender !!};
		var domicile = {!! $domicile !!};
		$("#birthTxt").datepicker({
			format: 'yyyy-mm-dd',
			defaultViewDate:new Date()
		});
		for(var i=0;i<gender.length;i++){
			$("#genderList").append($("<option value='"+gender[i].gender_id+"'>"+gender[i].gender_name+"</option>"));
		}
		for(var i=0;i<domicile.length;i++){
			$("#domicileList").append($("<option value='"+domicile[i].domicile_id+"'>"+domicile[i].domicile_name+"</option>"));
		}
		$("#saveBtn").click(function(e){
			var data = {
				name:$("#nameTxt").val(),
				gender:$("#genderList").val(),
				birth:$("#birthTxt").val(),
				domicile:$("#domicileList").val(),
				username:$("#usernameTxt").val(),
				pass:$("#passTxt").val(),
				confirm:$("#confirmpassTxt").val()
			};
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('/api/user/add') }}",
				data:data,
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
	})
</script>
@stop
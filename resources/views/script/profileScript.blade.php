@section("script")
<script>
	$(document).ready(function(){
		var gender = {!! $gender !!};
		var domicile = {!! $domicile !!};
		var profile = {!! $profile !!};
		for(var i=0;i<gender.length;i++){
			$("#genderList").append($("<option value='"+gender[i].gender_id+"'>"+gender[i].gender_name+"</option>"));
		}
		for(var i=0;i<domicile.length;i++){
			$("#domicileList").append($("<option value='"+domicile[i].domicile_id+"'>"+domicile[i].domicile_name+"</option>"));
		}
		if(profile != ""){
			$("#nameTxt").val(profile.full_name);
			$("#genderList").val(profile.gender_id);
			$("#birthTxt").val(profile.birth_date).datepicker({
				format: 'yyyy-mm-dd',
				defaultViewDate:profile.birth_date
			});
			$("#domicileList").val(profile.domicile_id);
		}
		$("#saveBtn").click(saveProfile);
	})
	function saveProfile(e){
		var data = {
			name:$("#nameTxt").val(),
			gender:$("#genderList").val(),
			birth:$("#birthTxt").val(),
			domicile:$("#domicileList").val(),
			pass:$("#passTxt").val(),
			newpass:$("#newpassTxt").val(),
			confirm:$("#confirmpassTxt").val()
		};
		$.ajax({
			headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
			url:"{{ URL::to('/api/profile/save') }}",
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
	}
</script>
@stop
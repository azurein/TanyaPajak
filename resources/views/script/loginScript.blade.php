@section("script")
<script>
	$(document).ready(function(){
		$("form").submit(login);
	})
	function login(e){
		e.preventDefault();
		$.ajax({
			headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
			url:"{{ URL::to('/api/user/login') }}",
			data:{
					username:$("#exampleInputEmail1").val(),
					password:$("#exampleInputPassword1").val()
				},
			type:"POST",
			success:function(data){
				if(data.error){
					location.href = "{{ URL::to('admin') }}";
				}
				else{					
					$("#warningMessage").text(data.message).removeClass("hide");
				}
			}
		})
	}
</script>
@stop
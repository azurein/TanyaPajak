@section("script")
<script>
	var currentUser = {!! $currentUser !!};
	function loadTable(user){
		if(typeof user == "undefined"){
			$.get( "{{ URL::to('/api/user/get') }}", function( data ) {
				loadTable(data);
			});
		}
		else{
			var table = $("#userList");
			$("tbody tr:visible",table).remove();
			for(var i=0;i<user.length;i++){
				var newRow = $("#trTemplate",table).clone().removeClass("hide").data("num",user[i].user_id);
				$(".iName",newRow).text(user[i].full_name);
				$(".iGender",newRow).text(user[i].gender_name);
				$(".iBirth",newRow).text(user[i].birth_date);
				$(".iDomicile",newRow).text(user[i].domicile_name);
				$(".iRole",newRow).text(user[i].role_name);
				$(".iEmail",newRow).text(user[i].username);
				if(user[i].role_id != 0){
					$(".iCheck",newRow).remove();
					$(".iAct",newRow).empty();
				}
				$(".iEdit",newRow).click(function(e){
					location.href = "{{ URL::to('/admin/user/edit/') }}#"+$(this).closest("tr").data("num");
				});
				$(".iDel",newRow).click(function(e){
					if(!confirm("Are you sure?"))return;
					$.ajax({
						headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
						url:"{{ URL::to('/api/user/delete') }}",
						data:{"list":[$(this).closest("tr").data("num")]},
						type:"POST",
						success:function(data){
							if(data.error){
								$("#warningMessage").addClass("hide");
								$("#successMessage").text(data.message).removeClass("hide");
								loadTable();
							}
							else{
								$("#successMessage").addClass("hide");
								$("#warningMessage").text(data.message).removeClass("hide");
							}
						}
					});
				});
				if(currentUser == user[i].user_id){
					$(".iCheck,.iDel,.iEdit",newRow).remove();
				}
				$("tbody",table).append(newRow);
			}
		}
	}
	$(document).ready(function(){
		loadTable({!! $users !!});
		
		$("#headerCheck").click(function(e){
			$(".iCheck:visible").prop("checked",$(this).prop("checked"));
		})
		$("#editSelected").click(function(e){
			var listNum = [];
			$(".iCheck:checked").each(function(i,e){
				listNum.push($(this).closest("tr").data("num"));
			})
			location.href="{{ URL::to('/admin/user/edit/') }}#"+listNum;
		});
		$("#deleteSelected").click(function(e){
			if(!confirm("Are you sure?"))return;
			var listNum = [];
			$(".iCheck:checked").each(function(i,e){
				listNum.push($(this).closest("tr").data("num"));
			})
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('/api/user/delete') }}",
				data:{"list":listNum},
				type:"POST",
				success:function(data){
					if(data.error){
						$("#warningMessage").addClass("hide");
						$("#successMessage").text(data.message).removeClass("hide");
						location.href="{{ URL::to('/admin/user/') }}";
					}
					else{
						$("#successMessage").addClass("hide");
						$("#warningMessage").text(data.message).removeClass("hide");
					}
				}
			});
		})
	})
</script>
@stop
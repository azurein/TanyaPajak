@section("script")
<script>
	function loadTable(tax){
		if(typeof tax == "undefined"){
			$.get( "{{ URL::to('/api/pendataan/get') }}", function( data ) {
				loadTable(data);
			});
		}
		else{
			var table = $("#taxList");
			$("tbody tr:visible",table).remove();
			for(var i=0;i<tax.length;i++){
				var newRow = $("#trTemplate",table).clone().removeClass("hide").data("num",tax[i].tax_type_id);
				$(".iName",newRow).text(tax[i].tax_type_name);
				$(".iDesc",newRow).text(tax[i].tax_type_descr);
				$(".iPercent",newRow).text(tax[i].percentage);
				$(".iEdit",newRow).click(function(e){
					location.href = "{{ URL::to('/admin/pendataan/edit/') }}#"+$(this).closest("tr").data("num");
				});
				$(".iDel",newRow).click(function(e){
					if(!confirm("Are you sure?"))return;
					$.ajax({
						headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
						url:"{{ URL::to('/api/pendataan/delete') }}",
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
				if(tax[i].is_shown == 0)
					$(".iShow",newRow).empty();
				$("tbody",table).append(newRow);
			}
		}
	}
	$(document).ready(function(){
		loadTable({!! $tax !!});
		$("#headerCheck").click(function(e){
			$(".iCheck:visible").prop("checked",$(this).prop("checked"));
		})
		$("#editSelected").click(function(e){
			var listNum = [];
			$(".iCheck:checked").each(function(i,e){
				listNum.push($(this).closest("tr").data("num"));
			})
			location.href="{{ URL::to('/admin/pendataan/edit/') }}#"+listNum;
		});
		$("#deleteSelected").click(function(e){
			if(!confirm("Are you sure?"))return;
			var listNum = [];
			$(".iCheck:checked").each(function(i,e){
				listNum.push($(this).closest("tr").data("num"));
			})
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('/api/pendataan/delete') }}",
				data:{"list":listNum},
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
		})
	})
</script>
@stop
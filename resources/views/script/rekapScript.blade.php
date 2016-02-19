@section("script")
<script>
	var monthNames = ["January", "February", "March", "April", "May", "June",
	  "July", "August", "September", "October", "November", "December"
	];
	$(document).ready(function(){
		$(".datepicker").datepicker({
			format: 'yyyy-mm-dd',
			setDate:new Date(),
			autoclose:true
		});
		$("#view").click(function(){
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('/api/rekap') }}",
				data:{
					start:$("#startDate").val(),
					end:$("#endDate").val(),
					period:$("#period").val()
				},
				type:"POST",
				success:function(data){
					if(data.error){
						var period = $("#period").val();
						$("#warningMessage").addClass("hide");
						$("#rekap").removeClass("hide");
						switch(parseInt(period)){
							case 1:
								$("#kolom_periode").text("Date");
							break;
							case 2:
								$("#kolom_periode").text("Month");
							break;
							case 3:
								$("#kolom_periode").text("Year");
							break;
						}
						var table = $("#rekap");
						var prevCount = 0;
						$("tbody tr:visible",table).remove();
						for(var i=0;i<data.log_data.length;i++){							
							var newRow = $("#trTemplate",table).clone().removeClass("hide");
							if(period==2)
								$(".iTime",newRow).text(monthNames[data.log_data[i].groupTime-1]);
							else
								$(".iTime",newRow).text(data.log_data[i].groupTime);
							$(".iTotalWeb",newRow).text(data.log_data[i].countUser);
							$(".iGrowthWeb",newRow).text(prevCount==0?0:Math.round(((data.log_data[i].countUser - prevCount)/prevCount*100)*100)/100);
							prevCount = data.log_data[i].countUser;
							$("tbody",table).append(newRow);
						}
					}
					else{
						$("#rekap").addClass("hide");
						$("#warningMessage").removeClass("hide").text(data.message);
					}
				}
			})
		})
	})
</script>
@stop
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
			$("table tbody tr:visible").remove();
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('/api/rekap/web') }}",
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
						for(var i=0;i<data.log_data.length;i++){							
							var newRow = $("#trTemplate",table).clone().removeClass("hide").attr("groupTime",data.log_data[i].groupTime);
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
						$("#warningMessage").removeClass("hide").text(data.message);
					}
					$.ajax({
						headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
						url:"{{ URL::to('/api/rekap/mobile') }}",
						data:{
							start:$("#startDate").val(),
							end:$("#endDate").val(),
							period:$("#period").val()
						},
						type:"POST",
						success:function(data){
							if(data.error){
								$("#mobileWarningMessage").addClass("hide");
								$("#rekap").removeClass("hide");
								var table = $("#rekap");
								var prevCount = 0;
								for(var i=0;i<data.log_data.length;i++){
									if(period==2){
										if($(".iTime:contains('"+monthNames[data.log_data[i].groupTime-1]+"')").length>0){
											$(".iTime:contains('"+monthNames[data.log_data[i].groupTime-1]+"')").siblings(".iTotalMobile").text(data.log_data[i].countUser);
											$(".iTime:contains('"+monthNames[data.log_data[i].groupTime-1]+"')").siblings(".iGrowthMobile").text(prevCount==0?0:Math.round(((data.log_data[i].countUser - prevCount)/prevCount*100)*100)/100);
										}
										else{
											var newRow = $("#trTemplate",table).clone().removeClass("hide").attr("groupTime",data.log_data[i].groupTime);
											$(".iTime",newRow).text(monthNames[data.log_data[i].groupTime-1]);
											$(".iTotalMobile",newRow).text(data.log_data[i].countUser);
											$(".iGrowthMobile",newRow).text(prevCount==0?0:Math.round(((data.log_data[i].countUser - prevCount)/prevCount*100)*100)/100);
											var checkTime = $("table tbody tr:visible:first");
											while(checkTime.attr("groupTime")+0<data.log_data[i].groupTime&&!checkTime.is(":last-child")){
												checkTime = checkTime.next();
											}
											if(checkTime.is(":last-child")){
												$("table tbody").append(newRow);
											}
											else{
												checkTime.before(newRow);
											}
										}
									}
									else{										
										if($(".iTime:contains('"+data.log_data[i].groupTime+"')").length>0){
											$(".iTime:contains('"+data.log_data[i].groupTime+"')").siblings(".iTotalMobile").text(data.log_data[i].countUser);
											$(".iTime:contains('"+data.log_data[i].groupTime+"')").siblings(".iGrowthMobile").text(prevCount==0?0:Math.round(((data.log_data[i].countUser - prevCount)/prevCount*100)*100)/100);
										}
										else{
											var newRow = $("#trTemplate",table).clone().removeClass("hide").attr("groupTime",data.log_data[i].groupTime);
											$(".iTotalMobile",newRow).text(data.log_data[i].countUser);
											$(".iGrowthMobile",newRow).text(prevCount==0?0:Math.round(((data.log_data[i].countUser - prevCount)/prevCount*100)*100)/100);
											$(".iTime",newRow).text(data.log_data[i].groupTime);
											var checkTime = $("table tbody tr:visible:first");
											while(checkTime.attr("groupTime")+0<data.log_data[i].groupTime&&!checkTime.is(":last-child")){
												checkTime = checkTime.next();
											}
											if(checkTime.is(":last-child")){
												$("table tbody").append(newRow);
											}
											else{
												checkTime.before(newRow);
											}
										}
									}
									prevCount = data.log_data[i].countUser;
									$("tbody",table).append(newRow);
								}
							}
							else{
								$("#mobileWarningMessage").removeClass("hide").text(data.message);
							}
						}
					})
				}
			})
		})
	})
</script>
@stop
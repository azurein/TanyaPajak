@section("script")
<script>
	var totalTransaction;
	var lastId = {{$lastId}};
	$(document).ready(function(){
		var split = document.cookie.split("; ");
		var tempType;
		for(var i=0;i<split.length;i++){
			if(split[i].split("=")[0] == "tname"){				
				$("#transactionType").text(split[i].split("=")[1]);
			}
			else if(split[i].split("=")[0] == "total"){
				$("#transactionTotal").text("Rp "+split[i].split("=")[1].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-");
				totalTransaction = parseInt(split[i].split("=")[1]);				
			}
			else if(split[i].split("=")[0] == "lastId"){
				$.ajax({
					headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
					url:"{{URL::to('api/simulasi/loadTax')}}",
					data:{typeId:split[i].split("=")[1]},
					type:"POST",
					success:function(data){
						var inc = 0;
						for(var i=0;i<data.result.length;i++){
							inc = Math.round(totalTransaction*parseInt(data.result[i].percentage)/100+parseInt(data.result[i].nominal));
							$("#taxContainer").append($("<h5 class='col-md-6' style='word-wrap:break-word;clear:both;'>"+data.result[i].tax_type_name+"("+data.result[i].percentage+"% + "+data.result[i].nominal+")</h5>"));
							$("#taxContainer").append($("<h5 class='col-md-6'>Rp "+(inc+"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-</h5>"));
							totalTransaction = Math.round((totalTransaction + inc) * 1e12) / 1e12;
						}
						$("#total").text("Rp "+(totalTransaction+"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-");
					}
				})
			}
		}
		$("#publishBtn").click(function(e){
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/simulasi/publish')}}",
				type:"POST",
				success:function(data){					
					location.href = "{{URL::to('admin/konfigurasi/')}}";
				}
			})
		})
		$("#backButton").click(function(){
			location.href='{{URL::to('admin/konfigurasi/simulate/tanya')}}/'+(lastId?lastId:"");
		})
	})
</script>
@stop
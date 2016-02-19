@section("script")
<script>
	var totalTransaction;
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
							inc = totalTransaction*parseInt(data.result[i].percentage)/100+parseInt(data.result[i].nominal);
							$("#taxContainer").append($("<h5 class='col-md-6'>"+data.result[i].tax_type_name+"("+data.result[i].percentage+"% + "+data.result[i].nominal+")</h5>"));
							$("#taxContainer").append($("<h5 class='col-md-6'>Rp "+(inc+"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-</h5>"));
							totalTransaction += inc;
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
	})
</script>
@stop
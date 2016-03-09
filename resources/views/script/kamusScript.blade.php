@section("script")
<script>
	function fullStringReq(){
		console.log("full");
		var parent = $(this).closest(".searchResult");
		$("p",parent).text(parent.data("fullString"));
		$(this).text("Ringkasan").off("click").click(subStringReq);
	}
	function subStringReq(){
		console.log("sub");
		var parent = $(this).closest(".searchResult");
		$("p",parent).text(parent.data("fullString").substring(0,100));
		$(this).text("Selengkapnya").off("click").click(fullStringReq);
	}
	$(document).ready(function(){
		var keyword = "{{$keyword}}";
		if(keyword){
			$("form input").val(keyword);
		}
		$("#searchButton").click(function(){
			$("form").submit();
		})
		$("form").submit(function(e){
			e.preventDefault();
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{ URL::to('api/data/kamuspajak') }}",
				data:{"Keyword":$("input",this).val()},
				type:"GET",
				success:function(data){
					var newTax;
					$(".searchResult").remove();
					for(var i=0;i<data.result.length;i++){
						newTax = $("<div class='input-group searchResult'></div>");
						newTax.append($("<p>"+data.result[i].tax_type_descr.substring(0,100)+"</p>"));
						if(data.result[i].tax_type_descr.length>100){
							$("p",newTax).append("...");
							newTax.append($("<a>Selengkapnya</a>").click(fullStringReq));
							newTax.data("fullString",data.result[i].tax_type_descr);
						}
						$("#searchContainer").append(newTax);
					}
				}
			});
		}).submit();
	})
</script>
@stop
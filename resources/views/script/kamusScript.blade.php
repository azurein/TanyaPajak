@section("script")
<script>
	$(document).ready(function(){
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
						newTax.append($("<h4>"+(i+1)+". "+data.result[i].tax_type_name+"</h4>"));
						newTax.append($("<p>"+data.result[i].tax_type_descr+"</p>"));
						$("#searchContainer").append(newTax);
					}
				}
			});
		}).submit();
	})
</script>
@stop
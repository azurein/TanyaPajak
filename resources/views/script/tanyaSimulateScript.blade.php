@section("script")
<script>
	var currParent;
	function loadQuestion(qa){
		$("#answerList").empty();
		$("#questionText").empty();
		console.log(qa);
		currParent = qa[0].parent_tax_qa_id;
		$("#questionText").text(qa[0].question);
		for(var i=0;i<qa.length;i++){
			var newAnswer = $("<a class='list-group-item'>"+qa[i].answer+"</a>");
			newAnswer.click(function(e){
				$(".active").removeClass("active");
				$(this).addClass("active");
			});
			newAnswer.data("id",qa[i].tax_qa_id);
			$("#answerList").append(newAnswer);
		}
	}
	$(document).ready(function(){
		var qa = {!! $QA !!};	
		if(qa.length>0){
			$("#prevBtn").click(function(){
				if(currParent == "-1"){
					location.href = "{{URL::to('admin/konfigurasi/simulate')}}";
				}
				else{
					$.ajax({
						headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
						url:"{{URL::to('api/simulasi/backSimulate')}}",
						data:"id="+qa[0].parent_tax_qa_id,
						type:"POST",
						success:function(data){
							if(data.result.length == 0){
								location.href = "{{URL::to('admin/konfigurasi/simulate')}}";
							}
							loadQuestion(data.result);
						}
					})
				}
			})
			$("#nextBtn").click(function(){
				if(typeof $(".active").data("id") == "undefined"){
					
				}
				else{
					$.ajax({
						headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
						url:"{{URL::to('api/simulasi/nextSimulate')}}",
						data:"id="+$(".active").data("id"),
						type:"POST",
						lastId:currParent,
						success:function(data){
							if(data.endQuestion){
								document.cookie = "lastId="+data.result;
								location.href = "{{URL::to('admin/konfigurasi/simulate/calculate')}}/"+this.lastId;
							}
							else{
								loadQuestion(data.result);
							}
						}
					})
				}
			})
			loadQuestion(qa);
		}
	})
</script>
@stop
@extends("template")

@section("content")
<script>
	var mapQA = {};
	$(document).ready(function(){
		var listQA = {!! $listQA !!};
		for(var i=0;i<listQA.length;i++){
			if($("#question").text() == ""){
				$("#question").text(listQA[i].question);
			}
			var newOpt = $("<a class='list-group-item' num='"+listQA[i].tax_qa_id+"'>"+listQA[i].answer+"</a>");
			$(newOpt).click(function(){
				$("a.list-group-item.active").removeClass("active");
				$(this).addClass("active");
			})
			$("#optionList").append(newOpt);
		}
		$("#loadNext").click(function(){
			/*
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/data/question/next')}}",
				data:data,
				type:"POST",
				success:function(data){
					
				}
			})
			*/
		});
		$("#loadBack").click(function(){
			/*
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/data/question/back')}}",
				data:data,
				type:"POST",
				success:function(data){
					
				}
			})
			*/
		});
	})
</script>
	<div class="container container-table">
		<div class="row vertical-center-row">
			<form>
				<div class="page-header">
					<h4 id="question"></h4>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="list-group" id="optionList">
						</div>
					</div>						
					<div class="input-group">							
						<div class="login-side"><button id="loadBack" onclick="location.href='{{ URL::to('admin/konfigurasi/simulate')}}';" type="button" class="btn btn-primary">Sebelumnya</button></div>
						<button type="button" class="btn btn-primary" id="loadNext">Selanjutnya</button>
					</div>
				</div>
			</form>
		</div>	
	</div>
@stop
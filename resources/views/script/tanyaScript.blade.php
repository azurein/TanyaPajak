@section("script")
<script>
	var currParent;
	var tax;
	var percent;
	var first = 0;
	var lastQa;
	var userId;
	function loadQuestion(qa){
		$("#answerList").empty();
		$("#questionText").empty();
		currParent = qa[0].parent_tax_qa_id;
		$("#questionText").text(qa[0].question);
		for(var i=0;i<qa.length;i++){
			var newAnswer = $("<a class='list-group-item'>"+qa[i].answer+"</a>");
			newAnswer.click(function(e){
				lastQa = $(this).data("id");
				$.ajax({
					headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
					url:"{{URL::to('api/simulasi/next')}}",
					data:"id="+$(this).data("id"),
					type:"POST",
					success:function(data){
						if(data.endQuestion){
							$.ajax({
								headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
								url:"{{URL::to('api/simulasi/loadTaxClient')}}",
								data:{
									user:userId,
									qaId:lastQa,
									typeId:data.result,
									val:$("#totalTransaction").val(),
									type:$("#transactionName").val(),
								},
								type:"POST",
								success:function(data){
									var inc = 0;
									var totalTransaction = parseInt($("#totalTransaction").val());
									$("#transactionType").text($("#transactionName").val());
									$("#transactionTotal").text(totalTransaction);
									for(var i=0;i<data.result.length;i++){
										inc = totalTransaction*parseInt(data.result[i].percentage)/100+parseInt(data.result[i].nominal);
										$("#taxContainer").append($("<h5 class='col-md-6'>"+data.result[i].tax_type_name+"("+data.result[i].percentage+"% + "+data.result[i].nominal+")</h5>"));
										$("#taxContainer").append($("<h5 class='col-md-6'>Rp "+(inc+"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-</h5>"));
										totalTransaction += inc;
									}
									$("#total").text("Rp "+(totalTransaction+"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-");
									$("#questionForm").addClass("hide");
									$("#calculateForm").removeClass("hide");
									$("con='calculateForm'").addClass("linknow").removeAttr("id");
								}
							})
						}
						else{
							loadQuestion(data.result);
						}
					}
				})
			});
			newAnswer.data("id",qa[i].tax_qa_id);
			$("#answerList").append(newAnswer);
		}
	}
	function firstLoad(){		
		var qa = {!! $QA !!};
		var gender = {!! $gender !!};
		var domicile = {!! $domicile !!};
		for(var i=0;i<gender.length;i++){
			$("#genderProfile").append($("<option value='"+gender[i].gender_id+"'>"+gender[i].gender_name+"</option>"))
		}
		for(var i=0;i<domicile.length;i++){
			$("#domicileProfile").append($("<option value='"+domicile[i].domicile_id+"'>"+domicile[i].domicile_name+"</option>"))
		}
		if(document.cookie.split(";").length>1){
			var cookieSplit = document.cookie.split("; ");
			var tempSubSplit;
			for(var i=1;i<cookieSplit.length;i++){
				tempSubSplit = cookieSplit[i].split("=");
				if(tempSubSplit[0] == "save" && !tempSubSplit[1])break;
				if(tempSubSplit[0] == "email"){
					$("#emailProfile").val(tempSubSplit[1]);
				}else if(tempSubSplit[0] == "name"){
					$("#nameProfile").val(tempSubSplit[1]);					
				}else if(tempSubSplit[0] == "gender"){
					$("#genderProfile").val(tempSubSplit[1]);					
				}else if(tempSubSplit[0] == "dateBirth"){
					$("#dateBirthProfile").val(tempSubSplit[1]);
				}else if(tempSubSplit[0] == "domicile"){
					$("#docmicileProfile").val(tempSubSplit[1]);
				}else if(tempSubSplit[0] == "save"){
					$("#saveOpt").prop("checked",tempSubSplit[1]);
				}
			}
		}
		loadQuestion(qa);
	}
	$(document).ready(function(){
		firstLoad();
		$("#resetBtn").click(function(){
			$("#profileForm input").val("");
			$("#saveOpt").prop("checked",false);
		})
		$("#nextProfileBtn").click(function(){
			var saveOpt = $("#saveOpt").prop("checked");
			if(saveOpt){
				document.cookie = "save="+$("#saveOpt").prop("checked");
				document.cookie = "email="+$("#emailProfile").val();
				document.cookie = "name="+$("#nameProfile").val();
				document.cookie = "gender="+$("#genderProfile").val();
				document.cookie = "dateBirth="+$("#dateBirthProfile").val();
				document.cookie = "domicile="+$("#domicileProfile").val();
			}
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/user/guestAdd')}}",
				data:{
					name:$("#nameProfile").val(),
					gender:$("#genderProfile").val(),
					birth:$("#dateBirthProfile").val(),
					domicile:$("#domicileProfile").val(),
					email:$("#emailProfile").val()
				},
				type:"POST",
				success:function(data){
					userId = data.id;
					if(data.error){
						$("#warningMessage").addClass("hide");
						$("#transactionForm").removeClass("hide");
						$("#profileForm").addClass("hide");
						$("[con='transactionForm']").addClass("linknow").removeAttr("id");
					}
					else{
						$("#warningMessage").text(data.message).removeClass("hide");
					}
				}
			});
		})
		$("#backTransactionBtn").click(function(){
			$("#transactionForm").addClass("hide");
			$("#profileForm").removeClass("hide");
		})
		$("#nextTransactionBtn").click(function(){
			var type = $("#transactionName").val();
			var total = $("#totalTransaction").val();
			if(type==""||total==""){
				$("#warningMessage").removeClass("hide").text("Please Input transaction type and total transaction");
				return;
			}
			else if(isNaN(parseInt(total)) || !isFinite(total)){
				$("#warningMessage").removeClass("hide").text("Total transaction must be a number");
				return;
			}
			$("#transactionForm").addClass("hide");
			$("#questionForm").removeClass("hide");
			$("[con='questionForm']").addClass("linknow").removeAttr("id");
		})
		$("#backCalculate").click(function(){
			$("#calculateForm").addClass("hide");
			$("#profileForm").removeClass("hide");
		})
		$("#resetCalculate").click(function(){
			$("#saveOpt").prop("checked",false);
			$("#emailProfile").val("");
			$("#nameProfile").val("");
			$("#genderProfile").val("");
			$("#dateBirthProfile").val("");
			$("#domicileProfile").val("");
			$("#calculateForm").addClass("hide");
			$("#transactionForm").removeClass("hide");
		})
		$(".datepicker").datepicker({
			format: 'yyyy-mm-dd',
			defaultViewDate:new Date()
		});
		$("ol").on("click",".linknow",function(){
			var curr = $(this);
			while(curr.length>0){				
				curr = $(curr).next();
				$(curr).attr("id","linknext");
			}
			$("form").addClass("hide");
			$("#"+$(this).attr("con")).removeClass("hide");
		})
	})
</script>
@stop
@section("script")
<script>
	var currParent;
	var tax;
	var percent;
	var first = 0;
	var lastQa;
	var userId;
	function loadNext(parent,nextObj){
		lastQa = $(parent).data("id");
		$.ajax({
			headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
			url:"{{URL::to('api/simulasi/next')}}",
			data:"id="+$(parent).data("id"),
			type:"POST",
			next:nextObj,
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
							$("#transactionTotal").text(("Rp "+(totalTransaction+"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-"));
							$("#taxContainer").empty();
							for(var i=0;i<data.result.length;i++){
								inc = Math.round((totalTransaction*parseInt(data.result[i].percentage)/100+parseInt(data.result[i].nominal))*100)/100;
								$("#taxContainer").append($("<a  style='word-wrap:break-word;clear:both;' href='{{URL::to("/kamus/")}}?key="+data.result[i].tax_type_name+"'><h5 class='col-md-6'>"+data.result[i].tax_type_name+"("+data.result[i].percentage+"% + "+data.result[i].nominal+")</h5>"));
								$("#taxContainer").append($("<h5 class='col-md-6'>Rp "+(inc+"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-</h5></a>"));
								totalTransaction = Math.round((totalTransaction + inc) * 1e12) / 1e12;
							}
							$("#total").text("Rp "+(totalTransaction+"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+".-");
							$("#questionForm").addClass("hide");
							$("#calculateForm").removeClass("hide");
							$("[con='calculateForm']").addClass("linknow").removeAttr("id");
						}
					})
				}
				else{
					loadQuestion(data.result,this.next);
				}
			}
		})
	}
	function loadQuestion(qa,next){
		$("#answerList").empty();
		$("#questionText").empty();
		currParent = qa[0].parent_tax_qa_id;
		$("#questionText").text(qa[0].question);
		var newQuestion = $('<a class="linknow questionLink"><li ans="'+currParent+'">'+qa[0].question+'?</li></a>');
		newQuestion.data("id",currParent);
		newQuestion.click(function(){
			$("form").addClass("hide");
			$("#questionForm").removeClass("hide");
			$("[con='calculateForm']").attr("id","linknext").removeClass("linknow");
			$(this).nextAll(".questionLink").attr("id","linknext").removeClass("linknow");
			$(this).nextAll(".questionLink").remove();
			loadNext(this,$(this).next());
			$(this).prevAll("")
			$(this).remove();
		});
		if(next){
			$(next).before(newQuestion);
		}
		else{
			$("ol a:last").before(newQuestion);
		}
		for(var i=0;i<qa.length;i++){
			var newAnswer = $("<a class='list-group-item'>"+qa[i].answer+"</a>");
			newAnswer.click(function(e){
				$("li[ans='"+$(this).data("parent")+"']").append($("<span class='userData'> "+$(this).text()+"</span>"));
				$("li[ans='"+$(this).data("parent")+"']").closest("a").next(".questionLink").remove();
				loadNext(this);
			});
			newAnswer.data("id",qa[i].tax_qa_id);
			newAnswer.data("parent",qa[i].parent_tax_qa_id);
			$("#answerList").append(newAnswer);
		}
	}
	function firstLoad(){
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
	}
	$(document).ready(function(){
		firstLoad();
		$("#roleForm").submit(function(e){
			e.preventDefault();			
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/data/searchRole')}}",
				data:{
					Keyword:$("input",this).val()
				},
				type:"GET",
				success:function(data){
					$("#roleList .roleItem").remove();
					for(var i=0;i<data.result.length;i++){
						var newRole = $("<a class='list-group-item roleItem'>"+data.result[i].role_name+"</a>")
										.data("id",data.result[i].role_id);
						newRole.click(function(){
							document.cookie = "role="+$(this).data("id");
							$("#roleForm").addClass("hide");
							$("#transactionForm").removeClass("hide");
							$("[con='transactionForm']").addClass("linknow").removeAttr("id");
							$("[con='roleForm'] .userData").remove();
							$("[con='roleForm'] li").append($("<span class='userData'> "+$(this).text()+"</span>"));
						})
						$("#roleList").append(newRole);
					}
				}
			})
		});
		$("#searchButton").click(function(){
			$(this).closest("form").submit();
		})
		$("#resetBtn").click(function(){
			if(!confirm("Are you sure?"))return;
			$("#profileForm").closest("div").find("input").val("");
			$("#saveOpt").prop("checked",false);
			document.cookie = "role=''";
			document.cookie = "save=''";
			document.cookie = "email=''";
			document.cookie = "name=''";
			document.cookie = "gender=''";
			document.cookie = "dateBirth=''";
			document.cookie = "domicile=''";
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
						$("#roleForm input").val("");
						$("#roleForm").removeClass("hide").submit();
						$("#profileForm").addClass("hide");
						$("[con='roleForm']").addClass("linknow").removeAttr("id");
					}
					else{
						$("#warningMessage").text(data.message).removeClass("hide");
					}
				}
			});
		})
		$("#backTransactionBtn").click(function(){
			$("#warningMessage").addClass("hide");
			$("#transactionForm").addClass("hide");
			$("#roleForm").removeClass("hide");
			$("[con='transactionForm']").attr("id","linknext").removeClass("linknow");
		})
		$("#nextTransactionBtn").click(function(){
			var qa = {!! $QA !!};
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
			$("#warningMessage").addClass("hide");
			$("#transactionForm").addClass("hide");
			$("#questionForm").removeClass("hide");
			$("[con='questionForm']").remove();
			$("[con='transactionForm'] .userData").remove();
			$("[con='transactionForm'] li").append($("<span class='userData'> "+type+" : "+total+" </span>"));
			loadQuestion(qa);
		})
		$("#backCalculate").click(function(){
			$(".questionLink:last").click();
		})
		$("#resetCalculate").click(function(){
			$(".questionLink").remove();
			$("[con='calculateForm']").removeClass("linknow").attr("id","linknext");
			$("[con='transactionForm']").after($('<a id="linknext" con="questionForm"><li>Tanya Jawab Pajak</li></a>'));
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
			if($(this).hasClass("questionLink")||$(this).attr("id") == "linknext"){
				return;
			}
			$('[con="questionForm"]').remove();
			var curr = $(this);
			while(curr.length>0){				
				curr = $(curr).next();
				$(curr).attr("id","linknext");
				$(".userData",curr).remove();
			}
			if(!$(this).is("[con='calculateForm']")){				
				$(".questionLink").remove();
				$("[con='calculateForm']").removeClass("linknow").attr("id","linknext");
				$("[con='transactionForm']").after($('<a id="linknext" con="questionForm"><li>Tanya Jawab Pajak</li></a>'));
			}
			$("form").addClass("hide");
			$("#"+$(this).attr("con")).removeClass("hide");
		})
	})
</script>
@stop
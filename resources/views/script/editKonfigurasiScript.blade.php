@section("script")
<script>
	var param = {{ $param }};
	var qa = {!! $selectedQA !!};
	var parentQA = {!! $selectedParent !!};
	var listQA = {!! $listQA !!};
	var listType = {!! $listType !!};
	var mapQA = {};
	function appendOnClick(e){
		var newAnswer = $("#answerTemplate").clone().removeClass("hide").removeAttr("id");
		$(".answerNum",newAnswer).text($(".answerContainer").length);
		$(".iInput",newAnswer).attr("placeholder","New Answer "+$(".answerContainer").length).focus();
		$(".iAction",newAnswer).click(appendOnClick);
		$(".answerContainer:last").after(newAnswer);
		return newAnswer;
	}
	$(document).ready(function(){
		var tempQA;
		if(param == 0){
			appendOnClick();
		}
		for(var i=0;i<listType.length;i++){
			$("#typeList").append($("<option value='"+listType[i].tax_type_id+"'>"+listType[i].tax_type_name+"</option>").attr("percent",listType[i].percentage));
		}
		for(var i=0;i<qa.length;i++){
			if($("#qText").val() == ""){
				$("#qText").val(qa[i].question);
			}
			if($(".answerContainer:visible").length == i){
				tempQA = appendOnClick();
				$(tempQA).attr("qa_id",qa[i].tax_qa_id);
				$(".iInput",tempQA).val(qa[i].answer);
			}
		}
		$("#endAnswer").click(function(){
			if($("#endAnswer").prop("checked")){
				$("#inputQuestionSection").addClass("hide");
				$("#endQuestionSection").removeClass("hide");
			}
			else{
				$("#inputQuestionSection").removeClass("hide");
				$("#endQuestionSection").addClass("hide");
			}
		});
		$("#newType").click(function(){
			var newType = $(this).closest(".typeItem").clone().removeAttr("detailId");
			$("button",newType).css("visibility","hidden").removeAttr("id");
			$(".typeNum",newType).text($(".typeItem").length+1);
			$("input",newType).val("");
			$("#typeList",newType).change(function(e){
				$("#percent",$(this).closest(".typeItem")).val($("option:selected",this).attr("percent"));
			})
			$("#typeList option:first",newType).prop("selected",true);
			$(this).closest(".typeItem").append($("button",newType).closest(".col-md-3"));
			$(newType).append($(this).closest(".col-md-3"));
			$("#typeContainer").append(newType);
		})
		$("#saveBtn").click(function(){
			var data = {};
			switch(param){
				case 0:
					if($("#endAnswer").prop("checked")){
						$(".typeItem").each(function(){
							data.question = $("#aChoise").val();
							data.type = $("#typeList",this).val();
							data.percent = $("#percent",this).val();
							data.nominal = $("#nominal",this).val();
							$.ajax({
								headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
								url:"{{URL::to('api/konfigurasi/finish')}}",
								data:data,
								type:"POST",
								success:function(data){
									if(data.error){
										$("#warningMessage").addClass("hide");
										$("#successMessage").text(data.message).removeClass("hide");
									}
									else{
										$("#successMessage").addClass("hide");
										$("#warningMessage").text(data.message).removeClass("hide");
									}
								}
							})
						})
					}
					else{
						data.parentQuestion = $("#aChoise").val();
						data.question = $("#qText").val();
						data.answer = [];
						$(".answerContainer:visible").each(function(i,e){
							data.answer.push($(".iInput",this).val());
						});
						console.log(data);
						$.ajax({
							headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
							url:"{{URL::to('api/konfigurasi/add')}}",
							data:data,
							type:"POST",
							success:function(data){
								if(data.error){
									$("#warningMessage").addClass("hide");
									$("#successMessage").text(data.message).removeClass("hide");
								}
								else{
									$("#successMessage").addClass("hide");
									$("#warningMessage").text(data.message).removeClass("hide");
								}
							}
						})
					}
				break;
				case 1:
					console.log("save");
					if($("#endAnswer").prop("checked")){
						$(".typeItem").each(function(){
							data.question = $("#aChoise").val();
							data.type = $("#typeList",this).val();
							data.percent = $("#percent",this).val();
							data.nominal = $("#nominal",this).val();
							if($(this).attr("detailId")){
								console.log("edit");
								data.detailId = $(this).attr("detailId");
								$.ajax({
									headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
									url:"{{URL::to('api/konfigurasi/editFinish')}}",
									data:data,
									type:"POST",
									success:function(data){
										if(data.error){
											$("#warningMessage").addClass("hide");
											$("#successMessage").text(data.message).removeClass("hide");
										}
										else{
											$("#successMessage").addClass("hide");
											$("#warningMessage").text(data.message).removeClass("hide");
										}
									}
								})
							}
							else{
								console.log(data);
								$.ajax({
									headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
									url:"{{URL::to('api/konfigurasi/finish')}}",
									data:data,
									type:"POST",
									success:function(data){
								console.log(data);
										if(data.error){
											$("#warningMessage").addClass("hide");
											$("#successMessage").text(data.message).removeClass("hide");
										}
										else{
											$("#successMessage").addClass("hide");
											$("#warningMessage").text(data.message).removeClass("hide");
										}
									}
								})
							}							
						})
					}
					else{
						data.parentQuestion = $("#aChoise").val();
						data.question = $("#qText").val();
						data.answer = [];
						var addData = $.extend(true, {}, data);
						var editData = $.extend(true, {}, data);
						var tempId;
						$(".answerContainer:visible").each(function(i,e){
							tempId = $(this).attr("qa_id");
							if (typeof tempId !== typeof undefined && tempId !== false) {
								editData.answer.push({
									answer: $(".iInput",this).val(),
									id:tempId
									});
								
							}else{
								addData.answer.push($(".iInput",this).val());
							}
						});
						$.ajax({
							headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
							url:"{{URL::to('api/konfigurasi/add')}}",
							data:addData,
							type:"POST",
							success:function(data){
								if(data.error){
									$("#warningMessage").addClass("hide");
									$("#successMessage").text(data.message).removeClass("hide");
								}
								else{
									$("#successMessage").addClass("hide");
									$("#warningMessage").text(data.message).removeClass("hide");
								}
							}
						})
						$.ajax({
							headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
							url:"{{URL::to('api/konfigurasi/edit')}}",
							data:editData,
							type:"POST",
							success:function(data){
								if(data.error){
									$("#warningMessage").addClass("hide");
									$("#successMessage").text(data.message).removeClass("hide");
								}
								else{
									$("#successMessage").addClass("hide");
									$("#warningMessage").text(data.message).removeClass("hide");
								}
							}
						})						
					}
				break;
				default:
				break;
			}
		});
		
		$("#aChoise").change(function(){
			if($(this).val()!=-1){
				$("#endAnswer").closest("div").removeClass("hide");
			}
			else{
				$("#endAnswer").closest("div").addClass("hide");
			}			
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/konfigurasi/loadRel')}}",
				data:{qaID:$(this).val()},
				type:"POST",
				success:function(data){
					if($(".typeItem").length>1){
						$(".typeItem:first button").closest(".col-md-3").remove();
						$(".typeItem:first").append($("#newType:visible").closest(".col-md-3"));
					}
					while($(".typeItem").length>1){
						$(".typeItem:last").remove();
					}
					while($(".answerContainer").length>2){
						$(".answerContainer:last").remove();
					}
					$(".typeItem #percent").val("");
					$(".typeItem #nominal").val("");
					$(".typeItem").removeAttr("detailId");
					$(".answerContainer .iInput").val("");
					$(".answerContainer").removeAttr("qa_id");
					$("#qText").val("");
					if(data.detail.length>0){
						$("#endAnswer").prop("checked",false).trigger("click");
						for(var i=0;i<data.detail.length;i++){
							$(".typeItem:last").attr("detailId",data.detail[i].tax_qa_detail_id);
							$(".typeItem:last #typeList").val(data.detail[i].tax_type_id);
							$(".typeItem:last #percent").val(data.detail[i].percentage);
							$(".typeItem:last #nominal").val(data.detail[i].nominal);
							if($(".typeItem:visible").length<data.detail.length)$("#newType").click();
						}
					}
					else{
						$("#endAnswer").prop("checked",true).trigger("click");
						if(data.child.length>0){
							for(var i=0;i<data.child.length;i++){
								$(".answerContainer:last").attr("qa_id",data.child[i].tax_qa_id);
								$(".answerContainer:last .iInput").val(data.child[i].answer);
								$("#qText").val(data.child[i].question);
								if($(".answerContainer:visible").length<data.child.length)$(".answerContainer:last .iAction").click();
							}
						}
					}
					param = 1;
				}
			})
		})
		$("#qChoise").change(function(){
			if($(this).val()!=-1){
				$("#endAnswer").closest("div").removeClass("hide");
			}
			else{
				$("#endAnswer").closest("div").addClass("hide");
				if($("#endAnswer").prop("checked")){
					$("#endAnswer").click();
				}
			}
			$("#aChoise").empty();
			if(typeof mapQA[$("option:selected",this).text()] == "undefined"){
				$("#aChoise").append("<option value='-1'></option>");
				return;
			}
			var tempMapA = mapQA[$("option:selected",this).text()];
			for(var i=0;i<tempMapA.length;i++){
				$("#aChoise").append("<option value='"+tempMapA[i].value+"'>"+tempMapA[i].answer+"</option>");
			}
			$("#aChoise").change();
		})
		for(var i=0;i<listQA.length;i++){
			if($("#qChoise option:contains('"+listQA[i].question+"')").length == 0){
				$("#qChoise").append("<option>"+listQA[i].question+"</option>");
			}
			if(typeof mapQA[listQA[i].question]=="undefined"){
				mapQA[listQA[i].question] = [{value:listQA[i].tax_qa_id,answer:listQA[i].answer}];
			}
			else{
				mapQA[listQA[i].question].push({value:listQA[i].tax_qa_id,answer:listQA[i].answer});
			}
		}
		if(parentQA){
			$("#qChoise option:contains(" + parentQA.question + ")").attr('selected', 'selected');
			$("#qChoise").change();
			$("#aChoise").val(parentQA.tax_qa_id);
		}
	})
</script>
@stop
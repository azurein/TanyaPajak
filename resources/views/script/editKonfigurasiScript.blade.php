@section("script")
<script>
	var param = {{ $param }};
	var qa = {!! $selectedQA !!};
	var parentQA = {!! $selectedParent !!};
	var listQA = {!! $listQA !!};
	var listType = {!! $listType !!};
	var typeEdit = {!! $typeEdit !!};
	var mapQA = {};
	var listDelType = [];
	var listDelQ = [];
	function appendType(){
		var newType = $(this).closest(".typeItem").clone().removeAttr("detailId");
		$(".typeNum",newType).text($(".typeItem").length+1);
		$("input",newType).val("");
		$("#typeList",newType).change(function(e){
			$("#percent",$(this).closest(".typeItem")).val($("option:selected",this).attr("percent"));
		})
		$("#typeList option:first",newType).prop("selected",true);
		$("#newType",newType).click(appendType);
		$("#delType",newType).click(delType);
		$("#typeContainer").append(newType);
		$("#typeList",newType).change();
	}
	function delType(){
		if($(".typeItem:visible").length<=1)return;
		if($(this).closest(".typeItem").attr("detailid")){
			listDelType.push($(this).closest(".typeItem").attr("detailid"));
		}
		$(this).closest(".typeItem").remove();		
		$(".typeItem").each(function(i){
			$(".typeNum",this).text(i+1);
		})
	}
	function appendOnClick(e){
		var newAnswer = $("#answerTemplate").clone().removeClass("hide").removeAttr("id");
		$(".answerNum",newAnswer).text($(".answerContainer").length);
		$(".iInput",newAnswer).attr("placeholder","New Answer "+$(".answerContainer").length).focus();
		$(".iActionPlus",newAnswer).click(appendOnClick);
		$(".iActionMinus",newAnswer).click(deleteOnClick);
		$(".answerContainer:last").after(newAnswer);
		return newAnswer;
	}
	function deleteOnClick(e){
		if($(".answerContainer:visible").length<=1)return;
		if($(this).closest(".answerContainer").attr("qa_id")){
			listDelQ.push($(this).closest(".answerContainer").attr("qa_id"));
		}
		$(this).closest(".answerContainer").remove();
		$(".answerContainer:visible").each(function(i){
			$(".answerNum",this).text(i+1);
			$(".iInput",this).attr("placeholder","New Answer "+(i+1)).focus();
		})
	}
	$(document).ready(function(){
		var tempQA;
		if(param == 0){
			appendOnClick();
		}
		for(var i=0;i<listType.length;i++){
			$("#typeList").append($("<option value='"+listType[i].tax_type_id+"'>"+listType[i].tax_type_name+"</option>").attr("percent",listType[i].percentage));
		}
		$("#typeList").change(function(e){
			$("#percent",$(this).closest(".typeItem")).val($("option:selected",this).attr("percent"));
		});
		$("#typeList").trigger("change");
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
		$("#newType").click(appendType);
		$("#delType").click(delType);
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
					if(listDelQ.length>0){
						$.ajax({
							headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
							url:"{{URL::to('api/konfigurasi/delQ')}}",
							data:{"listQ":listDelQ},
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
					if(listDelType.length>0){
						$.ajax({
							headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
							url:"{{URL::to('api/konfigurasi/delType')}}",
							data:{"listType":listDelType},
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
					if($("#endAnswer").prop("checked")){
						$(".typeItem").each(function(){
							data.question = $("#aChoise").val();
							data.type = $("#typeList",this).val();
							data.percent = $("#percent",this).val()==""?0:$("#percent",this).val();
							data.nominal = $("#nominal",this).val()==""?0:$("#nominal",this).val();
							if($(this).attr("detailId")){
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
					console.log(data);
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
							$(".answerContainer:visible:not(:first)").remove();
							for(var i=0;i<data.child.length;i++){
								$(".answerContainer:last").attr("qa_id",data.child[i].tax_qa_id);
								$(".answerContainer:last .iInput").val(data.child[i].answer);
								$("#qText").val(data.child[i].question);
								if($(".answerContainer:visible").length<data.child.length)
									$(".answerContainer:last .iActionPlus").click();
							}
						}
					}
					param = 1;
				}
			})
		})
		$("#qChoise").change(function(){
			if($(this).val()!=-2){
				$("#endAnswer").closest("div").removeClass("hide");
			}
			else{
				$("#endAnswer").closest("div").addClass("hide");
				if($("#endAnswer").prop("checked")){
					$("#endAnswer").click();
				}
			}
			$("#aChoise").empty();
			if(typeof mapQA[$(this).val()] == "undefined"){
				$("#aChoise").append("<option value='-1'></option>");
				return;
			}
			var tempMapA = mapQA[$(this).val()];
			for(var i=0;i<tempMapA.length;i++){
				$("#aChoise").append("<option value='"+tempMapA[i].value+"'>"+tempMapA[i].answer+"</option>");
			}
			if($(this).attr("changeChildVal")){
				$("#aChoise").val($(this).attr("changeChildVal"));
			}
			$("#aChoise").change();
			$(this).removeAttr("changeChildVal");
		})
		for(var i=0;i<listQA.length;i++){
			if($("#qChoise option[value='"+listQA[i].parent_tax_qa_id+"']").length == 0){
				$("#qChoise").append("<option value='"+listQA[i].parent_tax_qa_id+"'>"+listQA[i].question+"</option>");
			}
			if(typeof mapQA[listQA[i].parent_tax_qa_id]=="undefined"){
				mapQA[listQA[i].parent_tax_qa_id] = [{value:listQA[i].tax_qa_id,answer:listQA[i].answer}];
			}
			else{
				mapQA[listQA[i].parent_tax_qa_id].push({value:listQA[i].tax_qa_id,answer:listQA[i].answer});
			}
		}
		if(parentQA){
			$("#qChoise option[value='" + parentQA.parent_tax_qa_id + "']").attr('selected', 'selected');
			$("#qChoise").attr("changeChildVal",parentQA.tax_qa_id);
			$("#qChoise").change();
		}
	})
</script>
@stop
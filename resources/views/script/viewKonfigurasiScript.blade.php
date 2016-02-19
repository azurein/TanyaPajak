@section("script")
<script>
	var param = {!! $question !!};
	var arrowMargin = 30;
	var blockHeight = 50;
	var connectionBlock = {};
	var endQuestion = [];
	
	function startFocusOut() {
		$(document).click(function () {   
			$("#ctxCnt").hide();
			$(document).off("click");           
		});
	}
	function createArrow(pos1,pos4,svg,svgNS){
		var path = document.createElementNS(svgNS,'path');
		var pos2 = {x:pos1.x,y:pos1.y+(arrowMargin/2)},
		pos3 = {x:pos4.x,y:pos2.y};
		var randomColor = Math.floor(Math.random()*5592405).toString(16);
		while(randomColor.length!=6){
			randomColor="0"+randomColor;
		}
		path.setAttribute("stroke",'#'+randomColor);
		path.setAttribute("stroke-width","5px");
		path.setAttribute("fill","none");
		path.setAttribute("d","M"+parseInt(pos1.x)+","+parseInt(pos1.y)+" "+pos2.x+","+pos2.y+" "+pos3.x+","+pos3.y+" "+pos4.x+","+pos4.y+" ");
		svg.insertBefore(path, svg.firstChild);
	}
	function createBlock(p,w,h,msg,svg,svgNS){
		var text = document.createElementNS(svgNS,'text');
			text.setAttribute('fill','black');
			text.setAttribute('text-anchor','middle');
			text.setAttribute('x',p.x+w/2+1);
		var splitMsg = msg.split(" ");
		var tempMsg = "";
		if(msg.length > 18){
			text.setAttribute('y',p.y+20);
		}
		else{
			text.setAttribute('y',p.y+h/2);
		}
		for(var i=0;i<splitMsg.length;i++){
			if((tempMsg + splitMsg[i]+" ").length<18 && i<splitMsg.length-1){
				tempMsg += splitMsg[i]+" ";
				continue;
			}
			else if(i == splitMsg.length-1){
				tempMsg += splitMsg[i];
			}
			var tspan = document.createElementNS(svgNS,'tspan');
			tspan.setAttribute('x',p.x+w/2+1);
			if($("tspan",text).length==0)
				tspan.setAttribute('dy',0);
			else
				tspan.setAttribute('dy',20);
			tspan.textContent = tempMsg;
			text.appendChild(tspan);
			tempMsg = splitMsg[i]+" ";
		}
		svg.appendChild(text);
		var bbox = text.getBBox();
		var rect = document.createElementNS(svgNS,'rect');
			rect.setAttribute('x',p.x+1);
			rect.setAttribute('y',p.y);
			rect.setAttribute('width',w);
			rect.setAttribute('height',bbox.height+20);
			rect.setAttribute('stroke','black');
			rect.setAttribute('fill','white');
			rect.setAttribute('cursor','pointer');
		svg.appendChild(rect);
		svg.appendChild(text);
		rect.onmouseover = function(e){
			e.target.setAttribute('stroke','red');
		}
		rect.onmouseout = function(e){
			if(e.target.getAttribute("active") == 1)
				e.target.setAttribute('stroke','blue');
			else
				e.target.setAttribute('stroke','black');
		}
		rect.onclick = function(e){
			$("rect[stroke='blue']").attr({
				"stroke":"black",
				'active':0
			});
			$(this).attr({
				"stroke":"blue",
				'active':1
			});
		}
		return rect;
	}
	function drawKonfig(){
		var svg = $("#relationContainer")[0];
		var svgNS = svg.namespaceURI;
		var position = {x:0,y:0};
		var currQ = "";
		var tempSquare;
		var indQuestion;
		var questionPos;
		var tempPos;
		var currQFlag = -1;
		var i=0;
		for(;i<param.length;i++){
			if(param[i].tax_type_name){
				//ada akhir
				endQuestion.push({
					id:param[i].tax_qa_id,
					text:param[i].tax_type_name,
					rel:param[i].tax_qa_detail_id
				});
			};
			currQFlag = param[i].parent_tax_qa_id;
			if(currQFlag != param[i].parent_tax_qa_id && endQuestion.length>0){			
				for(var x=0;x<endQuestion.length;x++){	
					position.x = parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("x"));				
					position.y += parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("height"))+arrowMargin;
					createArrow({
						x:position.x+parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("width"))/2,
						y:parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("y"))+parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("height"))},{
						x:position.x+parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("width"))/2,
						y:position.y},svg,svgNS);
					tempRect = createBlock(position,parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("width")),blockHeight,endQuestion[x].text,svg,svgNS);
					tempSquare.setAttribute("squareType",2);
					tempRect.setAttribute("relId",endQuestion[x].rel);
				}
				endQuestion = [];
				position.x = 0;
			}
			if($("rect[qNum="+param[i].tax_qa_id+"]").length != 0)continue;
			console.log(param[i].parent_tax_qa_id);
			if(param[i].parent_tax_qa_id != -1 && $("rect[qNum="+param[i].parent_tax_qa_id+"]").length==0)continue;
			if(param[i].question !== currQ){
				indQuestion = param[i].tax_qa_id;
				if(param[i].parent_tax_qa_id == -1){
					position.x = $("#relationContainer").width()*0.375;
					tempSquare = createBlock(position,$("#relationContainer").width()/4,blockHeight,param[i].question,svg,svgNS);
					tempSquare.setAttribute("qSet","q"+indQuestion);
					tempSquare.setAttribute("pId",param[i].parent_tax_qa_id);
					tempSquare.setAttribute("squareType",0);
					questionPos = $.extend(true, {}, position);
					questionPos.x+=parseInt($(tempSquare).attr("width"))/2;
					questionPos.y+=parseInt($(tempSquare).attr("height"));
					position.y += tempSquare.getBBox().height+ arrowMargin;
					position.x = 0;
				}
				else{
					position.x = parseInt($("rect[qNum="+param[i].parent_tax_qa_id+"]").attr("x"));
					position.y += parseInt($("rect[qNum="+param[i].parent_tax_qa_id+"]").attr("height"))+arrowMargin;
					createArrow({
						x:position.x+parseInt($("rect[qNum="+param[i].parent_tax_qa_id+"]").attr("width"))/2,
						y:parseInt($("rect[qNum="+param[i].parent_tax_qa_id+"]").attr("y"))+parseInt($("rect[qNum="+param[i].parent_tax_qa_id+"]").attr("height"))},{
						x:position.x+parseInt($("rect[qNum="+param[i].parent_tax_qa_id+"]").attr("width"))/2,
						y:position.y},svg,svgNS);
					
					tempSquare = createBlock(position,$("rect[qNum="+param[i].parent_tax_qa_id+"]").attr("width"),blockHeight,param[i].question,svg,svgNS);
					tempSquare.setAttribute("qSet","q"+indQuestion);
					tempSquare.setAttribute("pId",param[i].parent_tax_qa_id);
					tempSquare.setAttribute("squareType",0);
					questionPos = $.extend(true, {}, position);
					questionPos.x+=parseInt($(tempSquare).attr("width"))/2;
					questionPos.y+=parseInt($(tempSquare).attr("height"));
					position.y += tempSquare.getBBox().height+ arrowMargin;
					position.x = 0;
				}
				currQ = param[i].question;
			}
			tempSquare = createBlock(position,$("#relationContainer").width()/param[i].parent_group - 10,blockHeight,param[i].answer,svg,svgNS);
			tempPos = $.extend(true, {}, position);
			tempPos.x+=$(tempSquare).attr("width")/2;
			createArrow(questionPos,tempPos,svg,svgNS);
			tempSquare.setAttribute("qNum",param[i].tax_qa_id);
			tempSquare.setAttribute("qSet","q"+indQuestion);
			tempSquare.setAttribute("squareType",1);
			position.x += tempSquare.getBBox().width + 10;
			$(tempSquare).contextmenu(function(e){
				e.preventDefault();
				$("#ctxCnt").css("left", e.clientX);
				$("#ctxCnt").css("top", e.clientY);
				$("#ctxCnt").fadeIn(500, startFocusOut());
				$("#ctxCnt").data("qNum",this.getAttribute("qNum"));
			});
		}
		
		if(endQuestion.length>0){
			i--;
			for(var x=0;x<endQuestion.length;x++){	
				position.x = parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("x"));				
				position.y += parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("height"))+arrowMargin;
				createArrow({
					x:position.x+parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("width"))/2,
					y:parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("y"))+parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("height"))},{
					x:position.x+parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("width"))/2,
					y:position.y},svg,svgNS);
				tempRect = createBlock(position,parseInt($("rect[qNum="+endQuestion[x].id+"]").attr("width")),blockHeight,endQuestion[x].text,svg,svgNS);
				tempRect.setAttribute("squareType",2);
				tempRect.setAttribute("relId",endQuestion[x].rel);
			}
			endQuestion = [];
			position.x = 0;
		}
		var bbox = svg.getBBox();
		svg.setAttribute("width", bbox.x + bbox.width  + "px");
		svg.setAttribute("height", bbox.y + bbox.height  + "px");
	}
	
	$(document).ready(function(){
		drawKonfig();
		$("#editKonfig").click(function(){
			if($("rect[active='1']").length == 0){
				alert("Please pick Question or Answer");
				return;
			}
			var allActive = [];
			var posy = $("rect[active='1']")[0].getAttribute("y");
			$("rect[y="+posy+"]").each(function(i,e){
				allActive.push(this.getAttribute("qNum"));
			});
			location.href='{{ URL::to("admin/konfigurasi/edit/1") }}?tes='+allActive;			
		})
		$("#delKonfig").click(function(){
			if(!confirm("Are you sure?"))return;
			var type = $("rect[active='1']")[0].getAttribute("squareType");
			if(type == 0){
				var qNum = $("rect[active='1']")[0].getAttribute("pId");
				$.ajax({
					headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
					url:"{{URL::to('api/konfigurasi/delQuestion')}}",
					data:{delNum:qNum},
					type:"POST",
					success:function(data){
						console.log(data);
						if(data.error){
							location.href = "{{ URL::to('admin/konfigurasi/view') }}";
						}
						else{
							$("#warningMessage").text(data.message).removeClass("hide");
						}
					}
				})
			}
			if(type == 1){
				var qNum = $("rect[active='1']")[0].getAttribute("qNum");
				$.ajax({
					headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
					url:"{{URL::to('api/konfigurasi/del')}}",
					data:{delNum:qNum},
					type:"POST",
					success:function(data){
						if(data.error){
							location.href = "{{ URL::to('admin/konfigurasi/view') }}";
						}
						else{
							$("#warningMessage").text(data.message).removeClass("hide");
						}
					}
				})
			}
			if(type == 2){
				var qNum = $("rect[active='1']")[0].getAttribute("relId");
				$.ajax({
					headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
					url:"{{URL::to('api/konfigurasi/delDetail')}}",
					data:{delNum:qNum},
					type:"POST",
					success:function(data){
						if(data.error){
							location.href = "{{ URL::to('admin/konfigurasi/view') }}";
						}
						else{
							$("#warningMessage").text(data.message).removeClass("hide");
						}
					}
				})
			}
			/*$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/konfigurasi/del')}}",
				data:{delNum:qNum},
				type:"POST",
				success:function(data){
					if(data.error){
						location.href = "{{ URL::to('admin/konfigurasi/view') }}";
					}
					else{
						$("#warningMessage").text(data.message).removeClass("hide");
					}
				}
			})*/
		})
		$("#incPriority").click(function(){
			var num = $(this).closest("div").data("qNum");
			console.log(num);
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/konfigurasi/incPriority')}}",
				data:{num:num},
				type:"POST",
				success:function(data){
					if(data){
						location.href = "{{ URL::to('admin/konfigurasi/view') }}";
					}
				}
			})
		})
		$("#decPriority").click(function(){
			var num = $(this).closest("div").data("qNum");
			console.log(num);
			$.ajax({
				headers:{'X-CSRF-Token': '{!! csrf_token() !!}' },
				url:"{{URL::to('api/konfigurasi/descPriority')}}",
				data:{num:num},
				type:"POST",
				success:function(data){
					if(data){
						location.href = "{{ URL::to('admin/konfigurasi/view') }}";
					}
				}
			})
		})
	})
</script>
@stop
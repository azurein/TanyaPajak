@extends("configurationTab")
@extends("script/editKonfigurasiScript")

@section("configurationContent")
<div class="form-group">
	<label>Question Parent</label>
	<select class="form-control" id="qChoise">
		<option value="-1"></option>
	</select>
</div>
<div class="form-group">
	<label>Answer Parent</label>
	<select class="form-control" id="aChoise">
		<option value="-1"></option>
	</select>
</div>
<div class="form-group hide"><br>
	<label class="checkbox-inline"><input id="endAnswer" type="checkbox" value="">End of Answer?</label>
</div>
<div id="inputQuestionSection">
	<div class="form-group">
		<label>Question</label>
		<input type="text" class="form-control" id="qText">
	</div>
	<div class="form-group answerContainer hide" id="answerTemplate">
		<label>Answer <span class="answerNum"></span></label>
		<div class="input-group">
			<input type="text" class="form-control iInput" aria-describedby="basic-addon1" />
			<span class="input-group-addon iActionPlus" style="cursor:pointer"><i class="fa fa-plus"></i></span>
			<span class="input-group-addon iActionMinus" style="cursor:pointer"><i class="fa fa-minus"></i></span>
		</div>
	</div>
</div>
<div id="endQuestionSection" class="hide">
	<div class="form-group">
		<div class="row">
			<div class="col-md-12">
				<div class="row" id="typeContainer">
					<div class="typeItem">
						<div class="col-md-3">
							<label>Tax Type <span class="typeNum">1</span></label>
							<select class="form-control" id="typeList">
							</select>
						</div>
						<div class="col-md-3">
							<label>Percentage <span class="typeNum">1</span></label>
							<input id="percent" type="text" class="form-control" placeholder="xx %">
						</div>
						<div class="col-md-3">
							<label>Nominal <span class="typeNum">1</span></label>
							<input id="nominal" type="text" class="form-control" placeholder="xx %">
						</div>
						<div class="col-md-3">
							<div class="form-group" style="line-height: 83px; padding-left:10px;">
								<div class="btn-group">
									<button id="newType" type="button" class="btn btn-default"><i class="fa fa-plus"></i></button>
									<button id="delType" type="button" class="btn btn-default"><i class="fa fa-minus"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group"><br>
	<button type="button" class="btn btn-default" id="saveBtn">Save</button>
</div>
<div class="alert alert-success hide" id="successMessage"></div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
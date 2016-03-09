@extends("contentTemplate")
@extends("script/rekapScript")

@section("mainContent")
<div class="page-header">
	<h3>Rekap Jumlah Pengguna</h3>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-4">
				<label>Start Date</label>
				<div class="input-group">
					<input id="startDate" type="text" class="form-control datepicker" aria-describedby="basic-addon1" placeholder="DD MMM YYYY">
					<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
			<div class="col-md-4">
				<label>End Date</label>
				<div class="input-group">
					<input id="endDate" type="text" class="form-control datepicker" aria-describedby="basic-addon1" placeholder="DD MMM YYYY">
					<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
			<div class="col-md-4">
				<label>Period</label>
				<select class="form-control" id="period">
					<option value="1">Daily</option>
					<option value="2">Monthly</option>
					<option value="3">Yearly</option>
				</select>	
			</div>
		</div>
	</div>
</div>
<br>
<div style="text-align: right;">
<button type="button" id="view" class="btn btn-default">View</button></div>
<br><br>
<div class="alert alert-danger hide" id="warningMessage"></div>
<div class="alert alert-danger hide" id="mobileWarningMessage"></div>
<table id="rekap" class="table table-bordered table-striped hide">
	<thead>
		<tr>
			<th width="20%" rowspan="2" style="line-height: 55px;" id="kolom_periode"></th>
			<th width="40%" colspan="2">
				Mobile Application
			</th>
			<th width="40%" colspan="2">
				Website
			</th>
		</tr>
		<tr>
			<th>
				Total User
			</th>
			<th>
				 Growth %
			</th>
			<th>
				Total User
			</th>
			<th>
				 Growth %
			</th>
		</tr>
	</thead>
	<tbody>
		<tr id="trTemplate" class="hide">
			<td class="iTime"></td>
			<td align="center" class="iTotalMobile"></td>
			<td align="center" class="iGrowthMobile"></td>
			<td align="center" class="iTotalWeb"></td>
			<td align="center" class="iGrowthWeb"></td>
		</tr>
	</tbody>
</table>
@stop
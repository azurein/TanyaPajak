@extends("contentTemplate")
@extends("script/pendataanScript")

@section("mainContent")
<div class="page-header">
	<h3>Pendataan Jenis Pajak</h3>
</div>
<table class="table table-bordered table-striped" id="taxList">
	<thead>
		<tr>
			<th width="5%">
				<input id="headerCheck" type="checkbox">
			</th>
			<th width="20%">
				Tax Type
			</th>
			<th width="30%">
				Description
			</th>
			<th width="10%">
				Tax %
			</th>
			<th width="15%">
				Dictionary
			</th>
			<th width="10%">
				Action
			</th>
		</tr>
	</thead>
	<tbody>
		<tr id="trTemplate" class="hide">
			<td align="center">
				<input class="iCheck" type="checkbox">
			</td>
			<td class="iName"></td>
			<td class="iDesc"></td>
			<td align="center" class="iPercent"></td>
			<td align="center" class="iShow">
				<i class="fa fa-check fa-lg"></i>
			</td>
			<td>
				<i class="fa fa-pencil fa-lg iEdit actionIcon"></i>
				<i class="fa fa-trash-o fa-lg iDel actionIcon"></i>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">
				<button type="button" class="btn btn-default" onclick="location.href='{{ URL::to('/admin/pendataan/add/') }}';">Add New</button>
				<button type="button" class="btn btn-default" id="editSelected">Edit Selected</button>
				<button type="button" class="btn btn-default" id="deleteSelected">Delete Selected</button>
			</td>
		</tr>
	</tfoot>
</table>
<div class="alert alert-success hide" id="successMessage"></div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
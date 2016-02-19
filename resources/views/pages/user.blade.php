@extends("contentTemplate")
@extends("script/userScript")

@section("mainContent")
<div class="page-header">
	<h3>User Management</h3>
</div>
<table id="userList" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="5%">
				<input type="checkbox" id="headerCheck">
			</th>
			<th width="15%">
				Full Name
			</th>
			<th width="10%">
				Gender
			</th>
			<th width="15%">
				Birth Date
			</th>
			<th width="13%">
				Domicile
			</th>
			<th width="13%">
				User Role
			</th>
			<th width="13%">
				Email
			</th>
			<th width="12%">
				Action
			</th>
		</tr>
	</thead>
	<tbody>
		<tr id="trTemplate" class="hide">
			<td align="center">
				<input type="checkbox" class="iCheck">
			</td>
			<td class="iName"></td>
			<td class="iGender"></td>
			<td class="iBirth">	</td>
			<td class="iDomicile"></td>
			<td class="iRole"></td>
			<td class="iEmail"></td>
			<td class="iAct">
				<i class="fa fa-pencil-square-o fa-lg iEdit actionIcon"></i>
				<i class="fa fa-trash-o fa-lg iDel actionIcon"></i>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">
				<button type="button" class="btn btn-default" onclick="location.href='{{ URL::to('/admin/user/add') }}';">Add New</button>
				<button type="button" class="btn btn-default" id="editSelected">Edit Selected</button>
				<button type="button" class="btn btn-default" id="deleteSelected">Delete Selected</button>
			</td>
		</tr>
	</tfoot>
</table>
<div class="alert alert-success hide" id="successMessage"></div>
<div class="alert alert-danger hide" id="warningMessage"></div>
@stop
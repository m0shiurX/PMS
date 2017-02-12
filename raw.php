<?php
	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';

	// Redirect visitor to the login page if he is trying to access
	// this page without being logged in
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
?>

	<div class="dashboard">
		<div class="col-md-12 col-sm-12" id="product_table">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h4> Raw Materials</h4>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
					<button type="button" name="add" id="add" class="btn btn-info" data-toggle="modal" data-target="#add_product">ADD</button>
				</div>
				<div class="col-md-6">
					<form class="form-inline pull-right">
					  <div class="form-group">
					    <label class="sr-only" for="search">Search for</label>
					    <div class="input-group">
					      <div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
					      <input type="text" class="form-control" id="search" placeholder="Type a name">
					      <div class="input-group-addon"><!-- <button type="submit" class="btn btn-info btn-xs">Search</button> --></div>
					    </div>
					  </div>
					 </form>
				</div>
			</div>
			<table id="grid-basic" class="table table-striped">
				<thead class="thead">
				  <tr class="info">
				    <th data-column-id="id" data-type="numeric">ID </th>
				    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
				    <th data-column-id="name"  data-type="text">Name</th>
				    <th data-column-id="unit">Unit</th>
				    <th data-column-id="details"Details</th>
				  </tr>
				</thead>
			  <tbody>
			  </tbody>
			</table>			
		</div>
		</div>
	</div>
	<!-- invisible content -->
	<!-- Insert modal -->
	<div class="fade modal" id="add_product">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4>Add new raw material</h4>
			</div>
			<form id="insert_form" method="POST">
			<div class="modal-body">
				<!-- The async form to send and replace the modals content with its response -->
				    <!-- form content -->
				      <div class="form-group">
				      	<label for="nm">Name</label>
				        <input type="text" class="form-control" id="nm" name="name" aria-describedby="emailHelp" placeholder="Enter Name" required>
				        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small> -->
				      </div>
				      <div class="form-group">
				        <label for="un">Unit</label>
				        <input type="text" class="form-control" id="un" name="unit" placeholder="Unit" required>
				      </div>
				      <div class="form-group">
				        <label for="dt">Details</label>
				        <input type="text" class="form-control" id="dt" name="details" placeholder="Details" required>
				      </div>
			</div>
			<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Submit</button>
			<a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
			</div>
			</form>
		  </div>
		</div>
	</div>
	<!-- modalend -->
	<?php
	include 'includes/footer.php';
	?>
	<script type="text/javascript">
		$('#insert_form').on('submit',function(event){
			event.preventDefault();
			$.ajax({
				url: "raw_process.php?p=add",
				method:"POST",
				data:$('#insert_form').serialize(),
				success: function (data) {
					$('#insert_form')[0].reset();
					$('#add_product').modal('hide');
					viewData();
				}
			});
		});
		function viewData() {
			$.ajax({
				method: "GET",
				url:"raw_process.php",
				success: function(data){
					$('tbody').html(data);
				}
			});
		}
		function delData(del_id){
			var id = del_id;
			$.ajax({
				method:"POST",
				url: "raw_process.php?p=del",
				data: "id="+id,
				success: function (data){
					viewData();
				}
			});
		}
		function upData(str){
			var id = str;
			var name = $('#nm-'+str).val();
			var unit = $('#un-'+str).val();
			var details = $('#dt-'+str).val();
			$.ajax({
				method:"POST",
				url: "raw_process.php?p=edit",
				data: "name="+name+"&unit="+unit+"&details="+details+"&id="+id,
				success: function (data){
					viewData();
				}
			});
		}
		// $("#grid-basic").bootgrid({
		// 	formatters: {
		// 	    "commands": function(column, row)
		// 	    {
		// 	        return "<button type=\"button\" class=\"btn btn-xs btn-danger command-edit\" data-row-id=\"" + row.id + "\" id=\"delete\"  onclick=\"delData("+row.id+")\">DELETE</button>"+"<button type=\"button\" class=\"btn btn-success btn-xs command-edit\" id=\"edit\" data-row-id=\"" + row.id + "\" data-toggle=\"modal\" data-target=\"#edit-"+ row.id+"\" onclick=\"upData("+row.id+")\">EDIT</button>";

		// 	    }
		// 	}
		// });
		window.onload = viewData();
		</script>
		<script type="text/javascript">
		  $(function() {
		    grid = $('#grid-basic');

		    // handle search fields of members key up event
		    $('#search').keyup(function(e) { 
		      text = $(this).val(); // grab search term

		      if(text.length > 1) {
		        grid.find('tr:has(td)').hide(); // hide data rows, leave header row showing

		        // iterate through all grid rows
		        grid.find('tr').each(function(i) {
		          // check to see if search term matches Name column
		          if($(this).find('.search').text().toUpperCase().match(text.toUpperCase()))
		            $(this).show(); // show matching row
		        });
		      }
		      else 
		        grid.find('tr').show(); // if no matching name is found, show all rows
		    });
		    
		  }); 
		</script>

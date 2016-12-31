<?php
	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';

	// Redirect visitor to the login page if he is trying to access
	// this page without being logged in
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
?>

	<div class="dashboard">

	<div class="col-md-12 col-sm-12" id="product_table">
	<h3>Raw Materials</h3>
	<hr>
	<button type="button" name="add" id="add" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#add_product">ADD</button>
	<table class="table table-striped">
		<thead class="thead-inverse">
		  <tr>
		    <th>ID </th>
		    <th>Action</th>
		    <th>Name</th>
		    <th>Unit</th>
		    <th>Details</th>
		  </tr>
		</thead>
	  <tbody>
	  </tbody>
	</table>
	</div>
	</div>
	<!-- invisible content -->
	<!-- Insert modal -->
	<div class="fade modal" id="add_product">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h2>Add new raw material</h2>
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
			<button type="submit" class="btn btn-primary btn-lg">Submit</button>
			<a href="#" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</a>
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
		window.onload=viewData();
	</script>

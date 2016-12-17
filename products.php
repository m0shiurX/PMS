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
	<h3>List of Products</h3>
	<hr>
	<button type="button" name="add" id="add" class="btn btn-info btn-lg" data-toggle="modal" data-target="#add_product">ADD</button>
	<table id="product_data" class="table table-striped">
		<thead class="thead-inverse">
		  <tr>
		    <th data-column-id="id" data-type="numeric">ID</th>
		    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
		    <th data-column-id="name">Name</th>
		    <th data-column-id="unit">Unit</th>
		    <th data-column-id="details">Details</th>
		    <th data-column-id="color">Color</th>
		    <th data-column-id="length" data-type="numeric">Length</th>
		    <th data-column-id="radious" data-type="numeric">Radious</th>
		    <th data-column-id="max" data-type="numeric">Max</th>
		    <th data-column-id="min" data-type="numeric">Min</th>
		  </tr>
		</thead>
	  <tbody>
	  </tbody>
	</table>
	</div>
	</div>
	<!-- invisible content -->
	<!-- New modal -->
	<div class="fade modal" id="add_product">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h2>Product Details</h2>
			</div>
				<form class="form-horizontal well" id="insert_form" method="POST">
			<div class="modal-body">
				<!-- The async form to send and replace the modals content with its response -->
				  <fieldset>
				    <!-- form content -->
				      <div class="form-group has-success">
				        <label for="name">Name</label>
				        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter Name" value="" required>
				        <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
				      </div>
				      <div class="form-group">
				        <label for="unit">Unit</label>
				        <input type="text" class="form-control" id="unit" name="unit" placeholder="Unit" value="" required>
				      </div>
				      <div class="form-group">
				        <label for="details">Details</label>
				        <input type="text" class="form-control" id="details" name="details" placeholder="Details" value="" required>
				      </div>
				      <!-- <div class="form-group">
				          <label for="category">Select Category</label>
				          <select class="form-control form-control-sm" name="category" id="category">
				            <option>Vegetable</option>
				            <option>Fastfood</option>
				            <option>Nolegistic</option>
				          </select>
				      </div> -->
				      <div class="form-group">
				        <label for="color">Color</label>
				        <input type="text" class="form-control" id="color" name="color" placeholder="Color" value="" required>
				      </div>

				      <div class="form-group">
				        <label for="length">Length</label>
				        <input type="text" class="form-control" id="length" name="length" placeholder="Length" value="" required>
				      </div>

				      <div class="form-group">
				        <label for="radious">Radious</label>
				        <input type="text" class="form-control" id="radious" name="radious" placeholder="Radious" value="" required>
				      </div>
				      <div class="form-group">
				        <label for="max">Max</label>
				        <input type="number" class="form-control" id="max" name="max" placeholder="Max" value="">
				      </div>
				      <div class="form-group">
				        <label for="min">Min</label>
				        <input type="number" class="form-control" id="min" name="min" placeholder="Min" value="">
				      </div>
				  </fieldset>
			</div>
			<div class="modal-footer">
			<button type="submit" class="btn btn-primary btn-lg" id="submit">Submit</button>
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
				url: "product_approve.php?p=add",
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
				url:"product_approve.php",
				success: function(data){
					$('tbody').html(data);
				}
			});
		}
		function delData(del_id){
			var id = del_id;
			$.ajax({
				method:"POST",
				url: "product_approve.php?p=del",
				data: "id="+id,
				success: function (data){
					viewData();
				}
			});
		}
		function upData(str){
			var name = $('#nm-'+str).val();
			var unit = $('#un-'+str).val();
			var details = $('#dt-'+str).val();
			var color = $('#cl'+str).val();
			var length = $('#ln'+str).val();
			var radious = $('#rd'+str).val();
			var max = $('$mx'+str).val();
			var min = $('$mn'+str).val();
			var id = str;
			$.ajax({
				method:"POST",
				url: "product_approve.php?p=edit",
				data: "name="+name+"&unit="+unit+"&details="+details+"&color="+color+"&length="+length+"&radious="+radious+"&max="+max+"&min="+min+"&id="+id,
				success: function (data){
					viewData();
				}
			});
		}
		window.onload=viewData();
	</script>


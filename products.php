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
	<?php
		require_once "includes/classes/admin-class.php";
		$admins = new Admins($dbh);
		$products = $admins->fetchProducts(); 
	?>
	<h3>List of Products</h3>
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
		    <th>Color</th>
		    <th>Length</th>
		    <th>Radious</th>
		    <th>Max</th>
		    <th>Min</th>
		  </tr>
		</thead>
	  <tbody>
	  <?php if (isset($products) && sizeof($products) > 0) :?>
	  	<?php foreach ($products as $product) :?>
	  		<tr>
	  			<th scope="row"><?=$product->pro_id ?></th>
	  			<td>
	  				<button type="button" id="add" class="btn btn-success">EDIT</button>
	  				<button type="button" id="add" class="btn btn-warning">DELETE</button>
	  			</td>
	  			<td><a data-toggle="modal" href="#rating-modal" title="Click to view details"><?= htmlspecialchars(strip_tags($product->pro_name)) ?></a></td>
	  			<td><?=$product->pro_unit?></td>
	  			<td><?=$product->pro_details?></td>
	  			<td><?=$product->pro_color?></td>
	  			<td><?=$product->pro_length?></td>
	  			<td><?=$product->pro_radious?></td>
	  			<td><?=$product->pro_max?></td>
	  			<td><?=$product->pro_min?></td>
	  		</tr>
	  	<?php endforeach ?>
	  <?php else: ?>
	  <i>No user is added yet.</i>
	  <?php endif ?>
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
				<form class="form-horizontal well" id="insert_form" action="product_approve.php" method="POST">
			<div class="modal-body">
				<!-- The async form to send and replace the modals content with its response -->
				  <fieldset>
				    <!-- form content -->
				      <div class="form-group">
				        <label for="username">Name</label>
				        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter Name" required>
				        <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
				      </div>
				      <div class="form-group">
				        <label for="unit">Unit</label>
				        <input type="text" class="form-control" id="unit" name="unit" placeholder="Unit" required>
				      </div>
				      <div class="form-group">
				        <label for="details">Details</label>
				        <input type="text" class="form-control" id="details" name="details" placeholder="Details" required>
				      </div>
				      <div class="form-group">
				        <label for="color">Color</label>
				        <input type="text" class="form-control" id="color" name="color" placeholder="Color" required>
				      </div>

				      <div class="form-group">
				        <label for="length">Length</label>
				        <input type="text" class="form-control" id="length" name="length" placeholder="Length" required>
				      </div>

				      <div class="form-group">
				        <label for="radious">Radious</label>
				        <input type="text" class="form-control" id="radious" name="radious" placeholder="Radious" required>
				      </div>
				      <div class="form-group">
				        <label for="max">Max</label>
				        <input type="number" class="form-control" id="max" name="max" placeholder="Max">
				      </div>
				      <div class="form-group">
				        <label for="min">Min</label>
				        <input type="number" class="form-control" id="min" name="min" placeholder="Min">
				      </div>
				  </fieldset>
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
	$(document).ready(function(){
		$('#insert_form').on('submit',function(event){
			event.preventDefault();
			$.ajax({
				url: "product_approve.php",
				method:"POST",
				data:$('#insert_form').serialize(),
				success: function (data) {
					$('#insert_form')[0].reset();
					$('#add_product').modal('hide');
					$('#product_table').html(data);
				}
			});
		});
	});
	</script>


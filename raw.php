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

	<div class="col-md-8 col-sm-12" id="product_table">
	<?php
		require_once "includes/classes/admin-class.php";
		$admins = new Admins($dbh);
		$products = $admins->fetchrawProducts(); 
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
		    <th>Quantity</th>
		  </tr>
		</thead>
	  <tbody>
	  <?php if (isset($products) && sizeof($products) > 0) :?>
	  	<?php foreach ($products as $product) :?>
	  		<tr>
	  			<th scope="row"><?=$product->raw_id ?></th>
	  			<td>
	  				<button type="button" id="add" class="btn btn-success">EDIT</button>
	  				<button type="button" id="add" class="btn btn-warning">DELETE</button>
	  			</td>
	  			<td><a data-toggle="modal" href="#rating-modal" title="Click to view details"><?= htmlspecialchars(strip_tags($product->raw_name)) ?></a></td>
	  			<td><?=$product->raw_unit?></td>
	  			<td><?=$product->raw_quantity?></td>
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
				<h2>Your Review</h2>
			</div>
				<form class="form-horizontal well" id="insert_form" action="user_approve.php" method="POST">
			<div class="modal-body">
				<!-- The async form to send and replace the modals content with its response -->
				  <fieldset>
				    <!-- form content -->
				      <div class="form-group">
				        <label for="username">Username</label>
				        <input type="username" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter email">
				        <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
				      </div>
				      <div class="form-group">
				        <label for="password">Password</label>
				        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				      </div>
				      <div class="form-group">
				        <label for="repassword">Re enter Password</label>
				        <input type="repassword" class="form-control" id="repassword" name="repassword" placeholder="Password">
				      </div>
				      <div class="form-group">
				        <label for="email">Email</label>
				        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
				      </div>
				      <div class="form-group">
				        <label for="fullname">Fullname</label>
				        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full name">
				      </div>

				      <div class="form-group">
				        <label for="address">Address</label>
				        <input type="textarea" class="form-control" id="address" name="address" placeholder="Address">
				      </div>

				      <div class="form-group">
				        <label for="contact">Contact</label>
				        <input type="tel" class="form-control" id="contact" name="contact" placeholder="Contact">
				      </div>
				  </fieldset>
			</div>
			<div class="modal-footer">
			<button form="ratting-form" type="button" class="btn btn-primary btn-lg">Submit</button>
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
				url: "user_approve.php",
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


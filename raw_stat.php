<?php
	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
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
	<table class="table table-striped">
		<thead class="thead-inverse">
		  <tr>
		    <th>ID </th>
		    <th>Name</th>
		    <th>Details</th>
		    <th>Quantity</th>
		    <th>Unit</th>
		  </tr>
		</thead>
	  <tbody>
	  <?php
	  $products = $admins->fetchrawProducts();
	  if (isset($products) && sizeof($products) > 0){ 
	  	foreach ($products as $product) { ?>
	  <tr>
	  	<td scope="row"><?=$product->raw_id ?></td>
	  	<td><?=$product->raw_name?></a></td>
	  	<td><?=$product->raw_details?></td>
	  	<td><?=$product->raw_quantity?></td>
	  	<td><?=$product->raw_unit?></td>
	  </tr>
	  <?php
	  	}
	  } ?>
	  </tbody>
	</table>
	</div>
	</div>
	<?php
	include 'includes/footer.php';
	?>

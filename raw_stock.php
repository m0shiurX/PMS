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
		<div class="col-md-12 col-sm-12">
		<div class="col-md-3"><h3>Statictics of Raw</h3></div>
		<div class="col-md-6"><hr></div>
		<div class="col-md-3 pull-right">
			<form class="form-inline  pull-right">
			  <div class="form-group">
			    <label class="sr-only" for="search">Search for</label>
			    <div class="input-group">
			      <div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
			      <input type="text" class="form-control" id="search" placeholder="Type a name">
			      <div class="input-group-addon"></div>
			    </div>
			  </div>
			<!-- <button type="submit" class="btn btn-info">Search</button> -->
			</form>
		</div>
		
		</div>
		<div class="col-md-12 col-sm-12" id="product_table">
			<table class="table table-striped table-bordered">
				<thead class="thead-inverse">
				  <tr>
				    <th>ID </th>
				    <th>Date</th>
				    <th>Raw ID</th>
				    <th>Name</th>
				    <th>Purhased</th>
				    <th>Used</th>
				  </tr>
				</thead>
			  <tbody>
			  <?php
			  $products = $admins->fetchrawEntry();
			  if (isset($products) && sizeof($products) > 0){ 
			  	foreach ($products as $product) {
			  		$proID = $product->raw_id;
			  		$proName = $admins->getArawProduct($proID);
			  		$product_name = $proName->raw_name;
			  		?>
			  <tr>
			  	<td scope="row"><?=$product->id?></td>
			  	<td><?=$product->date?></a></td>
			  	<td><?=$product->raw_id?></td>
			  	<td><?=$product_name?></td>
			  	<td><?=$product->raw_purchesed?></td>
			  	<td><?=$product->raw_used?></td>
			  </tr>
			  <?php
			  	}
			  } ?>
			  </tbody>
			</table>
		</div>
	</div>

	<?php include 'includes/footer.php'; ?>
	<script type="text/javascript">
		document.getElementById('date').valueAsDate = new Date();
	</script>
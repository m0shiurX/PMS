+<?php include 'includes/header.php'; ?>
<?php
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
?>
<div class="dashboard">
	<div class="col-md-12 col-sm-12">
	<h3 class="col-md-3">Statictics of Production</h3>
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
	<hr>
	<div class="col-md-12 col-sm-12">
		<table class="table table-striped table-bordered">
			<thead class="thead-inverse">
			  <tr>
			    <th>ID </th>
			    <th>Date</th>
			    <th>Product ID</th>
			    <th>Product Name</th>
			    <th>Sold</th>
			    <th>Waste</th>
			    <th>Return</th>
			  </tr>
			</thead>
		  <tbody>
		  	<?php 
		  	$products = $admins->fetchProductionData();
		  	if (isset($products) && sizeof($products) > 0){ 
		  	foreach ($products as $product) {
		  		$proID = $product->pro_id;

		  		$proName = $admins->getAProduct($proID);
		  		$product_name = $proName->pro_name;
		  		
		  		$proFinished = $admins->getfinishedProduct($proID);
		  		$finQty = $proFinished->pro_qty;

		  		$prounFinished = $admins->getunfinishedProduct($proID);
		  		$unfinQty = $prounFinished->pro_qty;
		  	?>
		    <tr>
		    	<td><?=$product->id?></td>
		    	<td><?=$product->date?></td>
		    	<td><?=$product->pro_id?></td>
		    	<td><?php echo $product_name; ?></td>
		    	<td><?=$product->pro_sold?></td>
		    	<td><?=$product->pro_waste?></td>
		    	<td><?=$product->pro_return?></td>
		    </tr>
		  <?php }} ?>
		  </tbody>
		</table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	document.getElementById('date').valueAsDate = new Date();
</script>
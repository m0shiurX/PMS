<?php include 'includes/header.php'; ?>
<?php
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
?>
	<div class="col-md-12 col-sm-12">
	<!-- <h3>Production Page</h3> -->
		<br>
	</div>
	<div class="clear"><br><br></div>
	<div class="col-md-12 col-sm-12">
		<table class="table table-striped">
			<thead class="thead-inverse">
			  <tr>
			    <th>ID </th>
			    <th>Action</th>
			    <th>Product ID</th>
			    <th>Product Name</th>
			    <th>Production</th>
			    <th>Finished</th>
			    <th>Unfinished</th>
			    <th>Date</th>
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
		    	<td><button type="button" id="delete" onclick="delData(<?=$product->pro_id?>)" class="btn btn-danger">DELETE</button></td>
		    	<td><?=$product->pro_id?></td>
		    	<td><?php echo $product_name; ?></td>
		    	<td><?=$product->pro_sold?></td>
		    	<td><?=$product->pro_waste?></td>
		    	<td><?=$product->pro_return?></td>
		    	<td><?=$product->date?></td>
		    </tr>
		  <?php }} ?>
		  </tbody>
		</table>
	</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	document.getElementById('date').valueAsDate = new Date();
</script>
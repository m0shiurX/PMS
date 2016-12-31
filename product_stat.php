<?php include 'includes/header.php'; ?>
<?php
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	if (isset($_POST['production'])) {
		$admins	= new Admins($dbh);
		$proselect = $_POST['proselect'];
		$production = $_POST['production'];
		$date = $_POST['date'];
		$finished = $_POST['finished'];
		$unfinished = $production-$finished;
		if (!$admins->insertProductData($proselect, $production, $date, $finished, $unfinished)) 
		{
			$msg = "Sorry Data could not be inserted !";
		}else {
			$msg =  "Well! You've successfully inserted new data!";
		}
	}
	if (isset($msg)) {echo "$msg";}
?>
	<div class="col-md-12 col-sm-12">
	<!-- <h3>Production Page</h3> -->
		<br>
	</div>
	<div class="clear"><br><br></div>
	<div class="col-md-12 col-sm-12">
	<?php	$categories = $admins->fetchCategory();
	foreach ($categories as $category) { $catname = $category->cat_name; ?>


	<div class="card">
	  <div class="card-header">
	    	<?php echo "<p>".$catname."</p>"; ?>
	  </div>
	  <div class="card-text">
		<table class="table table-striped">
			<thead class="thead">
			  <tr>		
			    <th>Product ID</th>
			    <th>Product Name</th>
			    <th>Details</th>
			    <th>Finished</th>
			    <th>Unfinished</th>
			    <th>Unit</th>
			  </tr>
			</thead>
		  <tbody>
				<?php
				$products = $admins->fetchProductsC($catname);
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
							<td><?=$product->pro_id?></td>
							<td><?=$product->pro_name?></td>
							<td><?=$product->pro_details?></td>
							<td><?=$finQty?></td>
							<td><?=$unfinQty?></td>
							<td><?=$product->pro_unit?></td>
						</tr>
				<?php
					}
				} ?>
		  </tbody>
		</table>
	  </div>
	</div>
	<?php }
		?>
	</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	document.getElementById('date').valueAsDate = new Date();
</script>
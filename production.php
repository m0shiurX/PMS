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
		<form class="form-inline" action="production.php" method="POST">
		  <div class="form-group">
	      <label for="proselect"></label>
	      <select class="form-control select-form-control" name="proselect" id="proselect">
				<?php $products = $admins->fetchProducts();
					if (isset($products) && sizeof($products) > 0){ 
					foreach ($products as $product) { ?>
					<option value='<?=$product->pro_id?>'><?=$product->pro_name?></option>
				<?php }} ?>
	      </select>
	      </div>
	      <div class="form-group">
	        <label class="sr-only" for="date">Date</label>
	        <input type="date" class="form-control" name="date" id="date" value="<?php echo date("m/d/y"); ?>">
	      </div>
	      <div class="form-group">
	        <label class="sr-only" for="production">Production</label>
	        <input type="number" class="form-control" name="production" id="production" placeholder="Total Production">
	      </div>
	      <div class="form-group">
	        <label class="sr-only" for="finished">Finishsed</label>
	        <input type="number" class="form-control" name="finished" id="finished" placeholder="Finishsed Production">
	      </div>
		  <button type="submit" class="btn btn-primary btn-lg">Insert DATA</button>
		</form>
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
				$products = $admins->fetchProduction();
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
			  	<td><?=$product->pro_qty?></td>
			  	<td><?php echo $finQty; ?></td>
			  	<td><?php echo $unfinQty; ?></td>
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
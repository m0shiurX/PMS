<?php include 'includes/header.php'; ?>
<?php
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	if (isset($_POST['sold'])) {
		$admins	= new Admins($dbh);
		$proselect = $_POST['proselect'];
		$sold = $_POST['sold'];
		$date = $_POST['date'];
		$waste = $_POST['waste'];
		$return = $_POST['return'];
		if (!$admins->insertProductionData($proselect, $sold, $date, $waste, $return)) 
		{
			$msg = "Sorry Data could not be inserted !";
		}else {
			$msg =  "Well! You've successfully inserted new data!";
		}
	}
	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';
	if($page == 'del'){
			$id = $_POST['id'];
			if (!$admins->deleteStocking($id)) 
			{
				$msg = "Sorry Data could not be deleted !";
			}else {
				$msg =  "Well! You've successfully deleted a product!";
			}
	}
?>
	<div class="col-md-12 col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5>Stocking : <?php if (isset($msg)) {echo "$msg";} ?></h5>
		</div>
		<div class="panel-body">
			<div class="col-md-12 col-sm-12">
				<form class="form-inline" action="daily_data.php" method="POST">
				  <div class="form-group">
			      <label for="proselect"></label>
			      <select class="form-control select-form-control" name="proselect" id="proselect" required>
			      		<option selected disabled value="" ="">Select a product</option>
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
			        <label class="sr-only" for="sold">Sold</label>
			        <input type="number" class="form-control" name="sold" id="sold" placeholder="Sold Production">
			      </div>
			      <div class="form-group">
			        <label class="sr-only" for="waste">Waste</label>
			        <input type="number" class="form-control" name="waste" id="waste" placeholder="Waste Production">
			      </div>
			      <div class="form-group">
			        <label class="sr-only" for="return">Waste</label>
			        <input type="number" class="form-control" name="return" id="return" placeholder="Return Production">
			      </div>
				  <button type="submit" class="btn btn-primary">Insert DATA</button>
				</form>
			</div>
		</div>
	</div>
	</div>
	<div class="col-md-12 col-sm-12">
		<table class="table table-striped table-bordered">
			<thead class="thead-inverse">
			  <tr>
			    <th>ID </th>
			    <th>Date</th>
			    <th>Action</th>
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
			  	<td><button type="button" data-id="<?=$product->id?>" class="btn btn-danger btn-sm delete">DELETE</button></td>
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
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	document.getElementById('date').valueAsDate = new Date();
	$('table').on('click', '.delete', function(e){
		var id = $(this).attr("data-id");
		var tr = $(this).closest("tr");
			$.ajax({
				method:"POST",
				url: "daily_data.php?p=del",
				data: "id="+id,
				success: function (data){
					//alert(id);
					//$tr.remove();
				}
			});
	    $(this).closest('tr').fadeOut(500);
	});
</script>
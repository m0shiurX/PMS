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
		<?php
			if (isset($_POST['raw_id'])) {
				$raw_id = $_POST['raw_id'];
				$date = $_POST['date'];
				$used = $_POST['used'];
				$purchased = $_POST['purchased'];
				$available = $purchased-$used;
				if (!$admins->insertRawData($raw_id, $date, $used, $purchased, $available)) 
				{
					$msg = "Sorry Data could not be inserted !";
				}else {
					$msg =  "Well! You've successfully inserted new data!";
				}
			}
			$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';
			if($page == 'del'){
					$id = $_POST['id'];
					if (!$admins->deleteRawData($id)) 
					{
						$msg = "Sorry Data could not be deleted !";
					}else {
						$msg =  "Well! You've successfully deleted a product!";
					}
			}
		?>

	<div class="dashboard">
		<div class="col-md-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5>Raw Materials : <?php if (isset($msg)) {echo "$msg";} ?></h5>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<form class="form-inline" action="raw_stat.php" method="POST">
						  <div class="form-group">
					      <label for="raw_id"></label>
					      <select class="form-control select-form-control" name="raw_id" id="raw_id" required>
					      		<option selected disabled value="" ="">Select a product</option>
								<?php $products = $admins->fetchrawProducts();
									if (isset($products) && sizeof($products) > 0){ 
									foreach ($products as $product) { ?>
									<option value='<?=$product->raw_id?>'><?=$product->raw_name?></option>
								<?php }} ?>
					      </select>
					      </div>
					      <div class="form-group">
					        <label class="sr-only" for="date">Date</label>
					        <input type="date" class="form-control" name="date" id="date" value="<?php echo date("m/d/y"); ?>">
					      </div>
					      <div class="form-group">
					        <label class="sr-only" for="used">Used Products</label>
					        <input type="number" class="form-control" name="used" id="used" placeholder="Used Products">
					      </div>
					      <div class="form-group">
					        <label class="sr-only" for="purchased">Purchased</label>
					        <input type="number" class="form-control" name="purchased" id="purchased" placeholder="Purchased Products">
					      </div>
						  <button type="submit" class="btn btn-primary">Insert DATA</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12" id="product_table">
			<table class="table table-striped table-bordered">
				<thead class="thead-inverse">
				  <tr>
				    <th>ID </th>
				    <th>Date</th>
				    <th>Action</th>
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
			  	<td><button type="button" data-id="<?=$product->id?>" class="btn btn-danger btn-sm delete">DELETE</button></td>
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
		$('table').on('click', '.delete', function(e){
			var id = $(this).attr("data-id");
			var tr = $(this).closest("tr");
				$.ajax({
					method:"POST",
					url: "raw_stat.php?p=del",
					data: "id="+id,
					success: function (data){
						//alert(id);
						//$tr.remove();
					}
				});
		    $(this).closest('tr').fadeOut(500);
		});
	</script>
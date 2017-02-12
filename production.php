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
			$msg = "<i class=\"warning\">Sorry Data could not be inserted !</i>";
		}else {
			$msg =  "<i class=\"success\">SorryWell! You've successfully inserted new data!</i>";
		}
	}
	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';
	if($page == 'del'){
			$id = $_POST['id'];
			if (!$admins->deleteProduction($id)) 
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
			<h5>Production : <?php if (isset($msg)) {echo "$msg";} ?></h5>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<form class="form-inline" action="production.php" method="POST">
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
				        <label class="sr-only" for="production">Production</label>
				        <input type="number" class="form-control" name="production" id="production" placeholder="Total Production" required="">
				      </div>
				      <div class="form-group">
				        <label class="sr-only" for="finished">Finishsed</label>
				        <input type="number" class="form-control" name="finished" id="finished" placeholder="Finishsed" required="">
				      </div>
					  <button type="submit" class="btn btn-primary">Insert</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12">
		<table id="grid-basic" class="table table-striped table-bordered">
			<thead class="thead-inverse">
			  <tr>
			    <th data-column-id="id" data-type="numeric">ID </th>
			    <th data-column-id="date" data-type="date">Date</th>
			    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
			    <th data-column-id="pro_id" data-type="numeric">Product ID</th>
			    <th data-column-id="name" data-type="text">Product Name</th>
			    <th data-column-id="production" data-type="numeric">Production</th>
			    <th data-column-id="finished" data-type="numeric">Finished</th>
			    <th data-column-id="unfinished" data-type="numeric">Unfinished</th>
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
			  	<td><?=$product->date?></td>
			  	<td>
			  		<button type="button" data-id="<?=$product->id?>" class="btn btn-danger btn-sm delete">DELETE</button>
			  	</td>
			  	<td><?=$product->pro_id?></td>
			  	<td><?php echo $product_name; ?></td>
			  	<td><?=$product->pro_qty?></td>
			  	<td><?=$product->pro_fin?></td>
			  	<td><?=$product->pro_unfin?></td>
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
				url: "production.php?p=del",
				data: "id="+id,
				success: function (data){
					//alert(id);
					//$tr.remove();
				}
			});
	    $(this).closest('tr').fadeOut(500);
	});
	// $("#grid-basic").bootgrid({
	// 	formatters: {
	// 	    "commands": function(column, row)
	// 	    {
	// 	        return "<button type=\"button\" id=\"delete\" class=\"btn btn-xs btn-danger command-edit delete\" data-id=\"" + row.id + "\">DELETE</button> ";

	// 	    }
	// 	}
	// });
	// function delData(del_id){
	// 	var id = del_id;
	// 	$.ajax({
	// 		method:"POST",
	// 		url: "production.php?p=del",
	// 		data: "id="+id,
	// 		success: function (data){
	// 			$(this).closest('tr').remove();
	// 		}
	// 	});
	// }
</script>
<?php

	// Start from getting the hader which contains some settings we need
	require_once 'includes/headx.php';
	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';

	if($page == 'add'){
			$name = $_POST['name'];
			$unit = $_POST['unit'];
			$details = $_POST['details'];
			$color = $_POST['color'];
			$length = $_POST['length'];
			$radious = $_POST['radious'];
			$max = $_POST['max'];
			$min = $_POST['min'];
			if (!$admins->addNewProduct($name, $unit, $details, $color, $length, $radious, $max, $min)) 
			{
				echo "Sorry Data could not be inserted !";
			}else {
				echo "Well! You've successfully inserted new data!";
			}
	}else if($page == 'del'){
		$id = $_POST['id'];
		if (!$admins->deleteProduct($id)) 
		{
			echo "Sorry Data could not be deleted !";
		}else {
			echo "Well! You've successfully deleted a product!";
		}

	}else if($page == 'edit'){
		$name = $_POST['name'];
		$unit = $_POST['unit'];
		$details = $_POST['details'];
		$color = $_POST['color'];
		$length = $_POST['length'];
		$radious = $_POST['radious'];
		$max = $_POST['max'];
		$min = $_POST['min'];
		$id = $_POST['id'];
		if (!$admins->updateProduct($id, $name, $unit, $details, $color, $length, $radious, $max, $min)) 
		{
			echo "Sorry Data could not be inserted !";
		}else {

			$commons->redirectTo(SITE_PATH.'products.php');
		}

	}else{
		$products = $admins->fetchProducts();
		if (isset($products) && sizeof($products) > 0){ 
			foreach ($products as $product) { ?>
				<tr>
					<td scope="row"><?=$product->pro_id?></td>
					<td>
						<button type="button" class="btn btn-success" id="edit" data-toggle="modal" data-target="#edit-<?=$product->pro_id?>">EDIT</button>
						<!-- Update modal -->
						<div class="fade modal" id="edit-<?=$product->pro_id?>">
							<div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<h2 id="datam">Edit Details</h2>
								</div>
								<form method="POST" action="product_approve.php?p=edit">
								<div class="modal-body">
									<!-- The async form to send and replace the modals content with its response -->
										<!-- form content -->
										<input type="hidden" name="id" id="<?=$product->pro_id?>" value="<?=$product->pro_id?>">
										  <div class="form-group has-success">
										    <label for="name">Name</label>
										    <input type="text" class="form-control" id="nm-<?=$product->pro_id?>" name="name" value="<?=$product->pro_name?>" required>
										  </div>
										  <div class="form-group">
										    <label for="unit">Unit</label>
										    <input type="text" class="form-control" id="un-<?=$product->pro_id?>" name="unit" value="<?=$product->pro_unit?>" required>
										  </div>
										  <div class="form-group">
										    <label for="details">Details</label>
										    <input type="text" class="form-control" id="dt-<?=$product->pro_id?>" name="details" value="<?=$product->pro_details?>" required>
										  </div>
										  <!-- <div class="form-group">
										      <label for="category">Select Category</label>
										      <select class="form-control form-control-sm" name="category" id="category">
										        <option>Vegetable</option>
										        <option>Fastfood</option>
										        <option>Nolegistic</option>
										      </select>
										  </div> -->
										  <div class="form-group">
										    <label for="color">Color</label>
										    <input type="text" class="form-control" id="cl-<?=$product->pro_id?>" name="color" value="<?=$product->pro_color?>" required>
										  </div>

										  <div class="form-group">
										    <label for="length">Length</label>
										    <input type="text" class="form-control" id="ln-<?=$product->pro_id?>" name="length" value="<?=$product->pro_length?>" required>
										  </div>

										  <div class="form-group">
										    <label for="radious">Radious</label>
										    <input type="text" class="form-control" id="rd-<?=$product->pro_id?>" name="radious" value="<?=$product->pro_radious?>" required>
										  </div>
										  <div class="form-group">
										    <label for="max">Max</label>
										    <input type="number" class="form-control" id="mx-<?=$product->pro_id?>" name="max" value="<?=$product->pro_max?>">
										  </div>
										  <div class="form-group">
										    <label for="min">Min</label>
										    <input type="number" class="form-control" id="mn-<?=$product->pro_id?>" name="min" value="<?=$product->pro_min?>">
										  </div>
								</div>
								<div class="modal-footer">
								<button type="submit" onclick="upData(<?=$product->pro_id?>)" class="btn btn-primary btn-lg">Update<?=$product->pro_id?></button>
								<a href="#" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</a>
								</div>
								</form>
							  </div>
							</div>
						</div>
						<!-- modalend -->
						<button type="button" id="delete" onclick="delData(<?=$product->pro_id?>)" class="btn btn-danger">DELETE</button>
					</td>
					<td><?=$product->pro_name?></td>
					<td><?=$product->pro_unit?></td>
					<td><?=$product->pro_details?></td>
					<td><?=$product->pro_color?></td>
					<td><?=$product->pro_length?></td>
					<td><?=$product->pro_radious?></td>
					<td><?=$product->pro_max?></td>
					<td><?=$product->pro_min?></td>
				</tr>
		<?php
			}
		}
	}
?>
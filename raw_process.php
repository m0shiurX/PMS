<?php

	require_once 'includes/headx.php';
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';

	if($page == 'add'){
			$name = $_POST['name'];
			$unit = $_POST['unit'];
			$details = $_POST['details'];

			if (!$admins->addRawProduct($name, $unit, $details)) 
			{
				echo "Sorry Data could not be inserted !";
			}else {
				echo "Well! You've successfully inserted new data!";
			}
	}else if($page == 'del'){
		$id = $_POST['id'];
		if (!$admins->deleterawProduct($id)) 
		{
			echo "Sorry Data could not be deleted !";
		}else {
			echo "Well! You've successfully deleted a product!";
		}

	}else if($page == 'edit'){
		$name = $_POST['name'];
		$unit = $_POST['unit'];
		$details = $_POST['details'];
		$id = $_POST['id'];
		if (!$admins->updateRawProduct($id, $name, $unit, $details)) 
		{
			echo "Sorry Data could not be inserted !";
		}else {
			echo "Well! You've successfully inserted new data!";
		}

	}else{
		$products = $admins->fetchrawProducts();
		if (isset($products) && sizeof($products) > 0){ 
			foreach ($products as $product) { ?>
				<tr>
					<td scope="row"><?=$product->raw_id ?></td>
					<td>
						<button type="button" class="btn btn-success btn-sm" id="edit" data-toggle="modal" data-target="#edit-<?=$product->raw_id?>">EDIT</button>
						<!-- Update modal -->
						<div class="fade modal" id="edit-<?=$product->raw_id?>">
							<div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<h4>Edit Raw Details</h4>
								</div>
								<form method="POST">
								<div class="modal-body">
									<!-- The async form to send and replace the modals content with its response -->
									    <!-- form content -->
									    	<input type="hidden" id="<?=$product->raw_id ?>" name="id" value="<?=$product->raw_id ?>">
									      <div class="form-group">
									      	<label for="nm">Name</label>
									        <input type="text" class="form-control" id="nm-<?=$product->raw_id ?>" name="name" aria-describedby="emailHelp" value="<?=$product->raw_name?>" focused>
									        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small> -->
									      </div>
									      <div class="form-group">
									        <label for="un">Unit</label>
									        <input type="text" class="form-control" id="un-<?=$product->raw_id ?>" name="unit" value="<?=$product->raw_unit?>">
									      </div>
									      <div class="form-group">
									        <label for="dt">Details</label>
									        <input type="text" class="form-control" id="dt-<?=$product->raw_id ?>" name="details" value="<?=$product->raw_details?>">
									      </div>
								</div>
								<div class="modal-footer">
								<button type="submit" onclick="upData(<?=$product->raw_id ?>)" class="btn btn-primary">Update</button>
								<a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
								</div>
								</form>
							  </div>
							</div>
						</div>
						<!-- modalend -->
						<button type="button" id="delete" onclick="delData(<?=$product->raw_id ?>)" class="btn btn-warning btn-sm">DELETE</button>
					</td>
					<td class="search"><?=$product->raw_name?></a></td>
					<td><?=$product->raw_unit?></td>
					<td><?=$product->raw_details?></td>
				</tr>
		<?php
			}
		}
	}
?>
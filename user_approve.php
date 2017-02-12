<?php

	// Start from getting the hader which contains some settings we need
	require_once 'includes/headx.php';

	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	// check if the form is submitted
	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';

	if($page == 'add'){
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$repassword = $_POST['repassword'];
			$fullname = $_POST['fullname'];
			$address = $_POST['address'];
			$contact = $_POST['contact'];

			if (isset($_POST)) 
			{

				$errors = array();

				// Check if password are the same
				if (!$admins->ArePasswordSame($_POST['password'], $_POST['repassword'])) 
				{
					session::set('errors', ['The two passwords do not match.']);
				}elseif ($admins->adminExists($_POST['username'])) {
					session::set('errors', ['This username is already in use by another admin.']);
				}elseif (!$admins->addNewAdmin($username, $password, $email, $fullname, $address, $contact)) {
					session::set('errors', ['An error occured while saving the new admin.']);
				}else{
					session::set('confirm', 'New admin added successfully!');
					unset($_POST['repassword']);
				}
			}
	}else if($page == 'del'){
		$id = $_POST['id'];
		if (!$admins->deleteUser($id)) 
		{
			echo "Sorry Data could not be deleted !";
		}else {
			echo "Well! You've successfully deleted a product!";
		}

	}else if($page == 'edit'){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$fullname = $_POST['fullname'];
		$address = $_POST['address'];
		$contact = $_POST['contact'];
		$user_id = $_POST['user_id'];
		if (!$admins->updateRawProduct($id, $name, $unit, $details)) 
		{
			echo "Sorry Data could not be inserted !";
		}else {
			echo "Well! You've successfully inserted new data!";
		}

	}else{
		$users = $admins->fetchAdmin(); 
		if (isset($users) && sizeof($users) > 0) {
			foreach ($users as $user){ ?>
				<tr>
					<td scope="row"><?=$user->user_id ?></td>
					<td>
						<!-- <button type="button" id="add" class="btn btn-success btn-sm">EDIT</button> -->
						<button type="button" id="delete" onclick="delData(<?=$user->user_id ?>)" class="btn btn-warning btn-sm">DELETE</button>
					</td>
					<td class="search"><?=$user->user_name?></td>
					<td class="search"><?=$user->full_name?></td>
					<td class="search"><?=$user->email?></td>
					<td class="search"><?=$user->contact?></td>
					<td class="search"><?=$user->address?></td>
				</tr>
			<?php
			}
		}
	}
?>
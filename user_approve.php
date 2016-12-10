<?php

	// Start from getting the hader which contains some settings we need
	require_once 'includes/headx.php';

	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	// check if the form is submitted


	if (isset($_POST)) 
	{
		// If the form is submitted

		$errors = array();

		foreach($_POST as $key => $value) 
		{
		  if(empty($value) || trim($value) == '') {
		    $errors[$key] =$key." should not be empty.";
		  }
		  $$key = $value;
		}

		// If there is any error we send back to the form
		if (!empty($errors) || sizeof($errors) != 0) 
		{
			session::set('errors', $errors);
		}

		// Check if password are the same
		if (!$admins->ArePasswordSame($_POST['password'], $_POST['repassword'])) 
		{
			session::set('errors', ['The two passwords do not match.']);
		}

		// From here you can unset the repassword field
		unset($_POST['repassword']);

		
		// Now let's check if another admin is not using the new username already
		if ($admins->adminExists($_POST['username'])) 
		{
			session::set('errors', ['This username is already in use by another admin.']);
		}

		// We've checked everything, 
		// now we can CREATE the admin in the admins table
		
		if (!$admins->addNewAdmin($username, $password, $email, $fullname, $address, $contact)) 
		{
			session::set('errors', ['An error occured while saving the new admin.']);
		}else {
			// Else we display a confirmation message
			session::set('confirm', 'New admin added successfully!');
		}
	if ( isset($_SESSION['errors']) ) {?>
	<div class="pannel panel-warning">
		<?php foreach ($_SESSION['errors'] as $error):?>
			<li><?= $error ?></li>
		<?php endforeach ?>
	</div>
	<?php session::destroy('errors');
		}

	}
?>
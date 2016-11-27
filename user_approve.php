<?php


	/*
	 * We process the admin login form here
	 */

	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';?>

<?php
	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins 	= new Admins($dbh);

	// check if the form is submitted


	if (isset($_POST)) 
	{
		// If the form is submitted
		
		// first we check if all fields are filled out
		// In our case all fields are required, so we can just loop
		$errors = array();

		foreach($_POST as $key => $value) 
		{
		  if(empty($value) || trim($value) == '') {
		    $errors[$key] = "The field ".$key." should not be empty.";
		  }
		  $$key = $value;
		}

		// If there is any error we send back to the form
		if (!empty($errors) || sizeof($errors) != 0) 
		{
			session::set('errors', $errors);
			$commons->redirectTo(SITE_PATH.'add_user.php');
		}

		// Check if password are the same
		if (!$admins->ArePasswordSame($_POST['password'], $_POST['repassword'])) 
		{
			session::set('errors', ['The two passwords do not match.']);
			$commons->redirectTo(SITE_PATH.'add_user.php');
		}

		// From here you can unset the repassword field
		// the password is in $_POST['password']
		unset($_POST['repassword']);

		
		// Now let's check if another admin is not using the new username already
		if ($admins->adminExists($_POST['username'])) 
		{
			session::set('errors', ['This username is already in use by another admin.']);
			$commons->redirectTo(SITE_PATH.'add_user.php');
		}

		// We've checked everything, 
		// now we can CREATE the admin in the admins table
		
		if (!$admins->addNewAdmin($username, $password)) 
		{
			session::set('errors', ['An error occured while saving the new admin.']);
			$commons->redirectTo(SITE_PATH.'add_user.php');
		}

		// Else we display a confirmation message
		session::set('confirm', 'New admin added successfully!');
		$commons->redirectTo(SITE_PATH.'add_user.php');

	}
?>
<?php
include 'includes/footer.php';
?>
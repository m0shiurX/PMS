<?php

	// Start from getting the hader which contains some settings we need
	require_once 'includes/headx.php';
	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	if (isset($_POST)) 
	{
		$errors = array();

		foreach($_POST as $key => $value){
			$$key = $value;
		}

		if(empty($value) || trim($value) == '') {
		    $errors[$key] = $key." should not be empty.";
		  } else{
		  	// Now let's check if another admin is not using the new username already
		  	if ($admins->productExists($_POST['name'])) 
		  	{
		  		session::set('errors', ['This product is already in database.']);
		  	}else{
		  		// We've checked everything, 
		  		// now we can CREATE the admin in the admins table
		  		
		  		if (!$admins->addNewProduct($name, $unit, $details, $color, $length, $radious, $max, $min)) 
		  		{
		  			session::set('errors', ['An error occured while saving the new admin.']);
		  		}else {
		  			// Else we display a confirmation message
		  			session::set('confirm', 'New admin added successfully!');
		  		}
		  	}
		  }

		// If there is any error we send back to the form
		if (!empty($errors) || sizeof($errors) != 0) 
		{
			session::set('errors', $errors);
		}	
		if ( isset($_SESSION['errors']) ) {?>
				<div class="card card-warning">
					<?php foreach ($_SESSION['errors'] as $error):?>
						<li><?= $error ?></li>
					<?php endforeach ?>
				</div>
			<?php session::destroy('errors');
			}
	}
?>
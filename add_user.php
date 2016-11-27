<?php
	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';

	// Redirect visitor to the login page if he is trying to access
	// this page without being logged in
	// if (!isset($_SESSION['admin_session']) )
	// {
	// 	$commons->redirectTo(SITE_PATH.'index.php');
	// }
?>

				<div class="dashboard">
					<h3>Add Admin</h3>
					<hr>
					<p>Please fill in the form bellow to add a new admin.</p>
					
					<?php  if ( isset($_SESSION['errors']) ): ?>
					<div class="pannel panel-warning">
						<?php foreach ($_SESSION['errors'] as $error):?>
							<li><?= $error ?></li>
						<?php endforeach ?>
					</div>
					<?php session::destroy('errors'); endif ?>

					<?php  if ( isset($_SESSION['confirm']) ): ?>
					<div class="pannel panel-success">
						<li><?= $_SESSION['confirm'] ?></li>
					</div>
					<?php session::destroy('confirm'); endif ?>


					<!-- We send the form information to process-new-admin.php to handle it -->
					<form action="process-new-admin.php" method="POST">
						<div>
							<label for="username">New Admin Username</label>
							<input type="text" name="username" id="username">
						</div>

						<div>
							<label for="password">New Admin Password</label>
							<input type="password" name="password" id="password">
						</div>

						<div>
							<label for="repassword">Re-enter Password</label>
							<input type="password" name="repassword" id="repassword">
						</div>
						
						<div class="activate">
							<button type="submit" class="btn-1a">Save Admin</button>
						</div>
					</form>
				</div>



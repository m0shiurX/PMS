<?php

	// Start from getting the header which contains some settings we need
	require_once 'includes/header.php';

	// Prevent admin from comming back here
	// if he's already logged in
	if (isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'index.php');
	}

?>
			<div class="admin-box">

				<?php  if ( isset($_SESSION['error']) ): ?>
					<div class="pannel panel-warning">
						<?= $_SESSION['error'] ?>
					</div>
				<?php session::destroy('error'); endif ?>

				<form action="approve.php" method="post">
					<div>
						<label for="username">Username</label>
						<input type="text" name="username" id="username" placeholder="zooboole">
					</div>
					<div>
						<label for="password">Password</label>
						<input type="password" name="password" id="password" placeholder="MySecr3t Pass WORD">
					</div>
					<div class="activate">
						<button type="submit" class="btn btn-1 btn-1a">Log in</button>
					</div>
				</form>
			</div>
<?php include 'includes/footer.php';

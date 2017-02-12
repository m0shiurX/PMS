<?php
	
	// Get the application settings and parameters

	require_once "includes/headx.php";
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset=" utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>

<!-- 	<link rel="stylesheet" href="component/css/reset.css">  -->
	<link rel="stylesheet" href="component/css/bootstrap.css"> <!-- CSS bootstrap -->
	<link rel="stylesheet" href="component/css/jquery.bootgrid.css"> <!-- Bootgrid stylesheet -->
	<link rel="stylesheet" href="component/css/style.css"> <!-- Resource style -->
	<script src="component/js/modernizr.js"></script> <!-- Modernizr -->

  	
	<title>SMS</title>
</head>
<body>
	<header class="cd-main-header">
		<a href="#0" class="cd-logo">KOROTOA</a>
		
		<!-- <div class="cd-search is-hidden">
			<form action="#0">
				<input type="search" placeholder="Search...">
			</form>
		</div>  cd-search -->

		<a href="#0" class="cd-nav-trigger"><span></span></a>

		<nav class="cd-nav">
			<ul class="cd-top-nav">
				<li><a href="#0">About</a></li>
				<li><a href="#0">Help</a></li>
				<li class="has-children account">
					<a href="#0">
						<img src="component/img/cd-avatar.png" alt="avatar">
						<?php echo $_SESSION["admin_session"]; ?>
					</a>
					<ul>

						<li><a href="#0">My Account</a></li>
						<li><a href="#0">Change Password</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</header> <!-- .cd-main-header -->

	<main class="cd-main-content">
		<nav class="cd-side-nav">
			<ul>
				<li class="cd-label">Main</li>
				<li class="has-children overview">
					<a href="index.php">Dashboard</a>
				</li>
				<li class="has-children overview active">
					<a href="#0">Statictics<!-- <span class="count">3</span> --></a>
					
					<ul>
						<li><a href="product_stat.php">Product Stock</a></li>
						<li><a href="production_stat.php">Product Statictics</a></li>
						<li><a href="raw_data.php">Raw Stock</a></li>
						<li><a href="raw_stock.php">Raw Statictics</a></li>
					</ul>
				</li>

				<li class="has-children overview active">
					<a href="#0">Stocking</a>
					<ul>
						<li><a href="production.php">Production</a></li>
						<li><a href="daily_data.php">Daily Stock</a></li>
						<li><a href="raw_stat.php">Raw</a></li>
					</ul>
				</li>
			</ul>

			<ul>
				<li class="cd-label">Administration</li>
				<li class="has-children bookmarks">
					<a href="products.php">Products</a>
				</li>
				<li class="has-children bookmarks">
					<a href="raw.php">Raw Materials</a>
				</li>

				<li class="has-children users">
					<a href="user.php">Users</a>
				</li>
			</ul>
			<!-- <ul>
				<li class="cd-label">Action</li>
				<li class="action-btn"><a href="#0">INSERT DATA</a></li>
			</ul> -->
		</nav>

		<div class="content-wrapper">
		<div class="container-fluid">
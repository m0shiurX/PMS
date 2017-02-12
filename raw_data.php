<?php
	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';

	// Redirect visitor to the login page if he is trying to access
	// this page without being logged in
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
?>

	<div class="dashboard">
	<div class="col-md-12 col-sm-12" id="product_table">
	<h3 class="col-md-3">Statictics of Raw materials</h3>
	<div class="col-md-3 pull-right">
		<form class="form-inline  pull-right">
		  <div class="form-group">
		    <label class="sr-only" for="search">Search for</label>
		    <div class="input-group">
		      <div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
		      <input type="text" class="form-control" id="search" placeholder="Type a name">
		      <div class="input-group-addon"></div>
		    </div>
		  </div>
		<!-- <button type="submit" class="btn btn-info">Search</button> -->
		</form>
	</div>
	<hr>
	<table id="grid-basic" class="table table-striped table-bordered">
		<thead class="thead">
		  <tr>
		    <th data-column-id="id" data-type="numeric">ID </th>
		    <th data-column-id="name">Name</th>
		    <th data-column-id="qnty" data-type="numeric">Quantity</th>
		    <th data-column-id="unit">Unit</th>
		    <th data-column-id="details" data-sortable="false">Details</th>
		  </tr>
		</thead>
	  <tbody>
	  <?php
	  $products = $admins->fetchrawProducts();
	  if (isset($products) && sizeof($products) > 0){ 
	  	foreach ($products as $product) { ?>
	  		<tr>
	  			<td scope="row"><?=$product->raw_id ?></td>
	  			<td class="search"><?=$product->raw_name?></a></td>
	  			<td><?=$product->raw_quantity?></td>
	  			<td><?=$product->raw_unit?></td>
	  			<td><?=$product->raw_details?></td>
	  		</tr>
	  <?php
	  	}
	  } ?>
	  </tbody>
	</table>
	</div>
	</div>

	<?php
	include 'includes/footer.php';
	?>
	<script type="text/javascript">
		//$("#grid-basic").bootgrid();
	</script>
	<script type="text/javascript">
	  $(function() {
	    grid = $('#grid-basic');

	    // handle search fields of members key up event
	    $('#search').keyup(function(e) { 
	      text = $(this).val(); // grab search term

	      if(text.length > 1) {
	        grid.find('tr:has(td)').hide(); // hide data rows, leave header row showing

	        // iterate through all grid rows
	        grid.find('tr').each(function(i) {
	          // check to see if search term matches Name column
	          if($(this).find('.search').text().toUpperCase().match(text.toUpperCase()))
	            $(this).show(); // show matching row
	        });
	      }
	      else 
	        grid.find('tr').show(); // if no matching name is found, show all rows
	    });
	    
	  }); 
	</script>
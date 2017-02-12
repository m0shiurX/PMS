<?php include 'includes/header.php'; ?>
<?php
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	if (isset($_POST['production'])) {
		$admins	= new Admins($dbh);
		$proselect = $_POST['proselect'];
		$production = $_POST['production'];
		$date = $_POST['date'];
		$finished = $_POST['finished'];
		$unfinished = $production-$finished;
		if (!$admins->insertProductData($proselect, $production, $date, $finished, $unfinished)) 
		{
			$msg = "Sorry Data could not be inserted !";
		}else {
			$msg =  "Well! You've successfully inserted new data!";
		}
	}
	if (isset($msg)) {echo "$msg";}
?>
	<div class="col-md-12 col-sm-12">
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
	<div class="col-md-12 col-sm-12">
	<?php	$categories = $admins->fetchCategory();
	foreach ($categories as $category) { $catname = $category->cat_name; ?>

		<div id="grid-basic" class="panel panel-default">
		  <div class="panel-heading">
		    	<?=$catname?>
		  </div>
		  <div class="">
		  </div>
			<table class="table table-striped">
				<thead class="thead table-inverse">
				  <tr>		
				    <th>Product ID</th>
				    <th>Product Name</th>
				    <th>Details</th>
				    <th>Finished</th>
				    <th>Unfinished</th>
				    <th>Unit</th>
				  </tr>
				</thead>
			  <tbody>
					<?php
					$products = $admins->fetchProductsC($catname);
					if (isset($products) && sizeof($products) > 0){
							foreach ($products as $product) {
							$proID = $product->pro_id;

							$proName = $admins->getAProduct($proID);
							$product_name = $proName->pro_name;
							
							$proFinished = $admins->getfinishedProduct($proID);
							$finQty = $proFinished->pro_qty;

							$prounFinished = $admins->getunfinishedProduct($proID);
							$unfinQty = $prounFinished->pro_qty;
						 ?>
							<tr>
								<td><?=$product->pro_id?></td>
								<td class="search"><?=$product->pro_name?></td>
								<td><?=$product->pro_details?></td>
								<td><?=$finQty?></td>
								<td><?=$unfinQty?></td>
								<td><?=$product->pro_unit?></td>
							</tr>
					<?php
						}
					}else{ ?>
						<script type="text/javascript">
						  $(function() {
						    $(this)find('table').hide();
						    // handle search fields of members key up event
						    //grid.find('tr:has(th)').hide();
						    
						  }); 
						</script> <?php
						} ?>
			  </tbody>
			</table>
		</div>
	<?php }
		?>
	</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	document.getElementById('date').valueAsDate = new Date();
</script>
<script type="text/javascript">
  $(function() {
    grid = $('.panel');

    // handle search fields of members key up event
    //grid.find('tr:has(th)').hide();
    
  }); 
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
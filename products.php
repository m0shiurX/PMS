<?php
	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';
	// Redirect visitor to the login page if he is trying to access
	// this page without being logged in
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
?>

	<div class="dashboard">

	<div class="col-md-12 col-sm-12" id="product_table">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Products</h4>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<button type="button" name="add" id="add" class="btn btn-info" data-toggle="modal" data-target="#add_product">ADD</button>
			</div>
			<div class="col-md-6">
				<form class="form-inline pull-right">
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
		</div>
		<table id="product_data" class="table table-striped">
			<thead class="thead">
			  <tr class="info">
			    <th>ID</th>
			    <th>Action</th>
			    <th>Name</th>
			    <th>Unit</th>
			    <th>Details</th>
			    <th>Category</th>
			    <th>Color</th>
			    <th>Length</th>
			    <th>Radious</th>
			    <th>Max</th>
			    <th>Min</th>
			  </tr>
			</thead>
		  <tbody>
		  </tbody>
		</table>
	</div>
	</div>
	</div>
	<!-- invisible content -->
	<!-- New modal -->
	<div class="fade modal" id="add_product">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4>Product Details</h4>
			</div>
				<form class="form-horizontal well" id="insert_form" method="POST">
			<div class="modal-body">
				<!-- The async form to send and replace the modals content with its response -->
				  <fieldset>
				    <!-- form content -->
				      <div class="form-group has-success">
				        <label for="name">Name</label>
				        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter Name" value="" required>
				        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small> -->
				      </div>
				      <div class="form-group">
				        <label for="unit">Unit</label>
				        <input type="text" class="form-control" id="unit" name="unit" placeholder="Unit" value="" required>
				      </div>
				      <div class="form-group">
				        <label for="details">Details</label>
				        <input type="text" class="form-control" id="details" name="details" placeholder="Details" value="" required>
				      </div>
				      <div class="form-group">
				          <label for="category">Select Category</label>
				          <select class="form-control form-control-sm" name="category" id="category">
				            <?php 
				            require_once "includes/classes/admin-class.php";
				            $admins	= new Admins($dbh);
				            $categories = $admins->fetchCategory();
				            	if (isset($categories) && sizeof($categories) > 0){ 
				            	foreach ($categories as $category) { ?>
				            	<option value='<?=$category->cat_name?>'><?=$category->cat_name?></option>
				            <?php }} ?>
				          </select>
				      </div>
				      <div class="form-group">
				        <label for="color">Color</label>
				        <input type="text" class="form-control" id="color" name="color" placeholder="Color" value="" required>
				      </div>

				      <div class="form-group">
				        <label for="length">Length</label>
				        <input type="text" class="form-control" id="length" name="length" placeholder="Length" value="" required>
				      </div>

				      <div class="form-group">
				        <label for="radious">Radious</label>
				        <input type="text" class="form-control" id="radious" name="radious" placeholder="Radious" value="" required>
				      </div>
				      <div class="form-group">
				        <label for="max">Max</label>
				        <input type="number" class="form-control" id="max" name="max" placeholder="Max" value="">
				      </div>
				      <div class="form-group">
				        <label for="min">Min</label>
				        <input type="number" class="form-control" id="min" name="min" placeholder="Min" value="">
				      </div>
				  </fieldset>
			</div>
			<div class="modal-footer">
			<button type="submit" class="btn btn-primary btn-sm" id="submit">Submit</button>
			<a href="#" class="btn btn-warning btn-sm" data-dismiss="modal">Cancel</a>
			</div>
				</form>
		  </div>
		</div>
	</div>
	<!-- modalend -->
	<?php
	include 'includes/footer.php';
	?>
	<script type="text/javascript">

		$('#insert_form').on('submit',function(event){
			event.preventDefault();
			$.ajax({
				url: "product_approve.php?p=add",
				method:"POST",
				data:$('#insert_form').serialize(),
				success: function (data) {
					$('#insert_form')[0].reset();
					$('#add_product').modal('hide');
						viewData();
				}
			});
		});
		function viewData() {
			$.ajax({
				method: "GET",
				url:"product_approve.php",
				success: function(data){
					$('tbody').html(data);
				}
			});
		}
		function delData(del_id){
			var id = del_id;
			$.ajax({
				method:"POST",
				url: "product_approve.php?p=del",
				data: "id="+id,
				success: function (data){
					viewData();
				}
			});
		}
		function upData(str){
			var name = $('#nm-'+str).val();
			var unit = $('#un-'+str).val();
			var details = $('#dt-'+str).val();
			var color = $('#cl'+str).val();
			var length = $('#ln'+str).val();
			var radious = $('#rd'+str).val();
			var max = $('$mx'+str).val();
			var min = $('$mn'+str).val();
			var id = str;
			$.ajax({
				method:"POST",
				url: "product_approve.php?p=edit",
				data: "name="+name+"&unit="+unit+"&details="+details+"&color="+color+"&length="+length+"&radious="+radious+"&max="+max+"&min="+min+"&id="+id,
				success: function (data){
					viewData();
				}
			});
		}
		window.onload=viewData();
	</script>

	<script type="text/javascript">
	  $(function() {
	    grid = $('#product_data');

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
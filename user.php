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

	<div class="col-md-12 col-sm-12" id="employee_table">
		<?php
			require_once "includes/classes/admin-class.php";
			$admins = new Admins($dbh);
			$users = $admins->fetchAdmin(); 
		?>
		<h3>List of Users</h3>
		<hr>
		<button type="button" name="add" id="add" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#add_data_Modal">ADD</button>
		<table class="table table-striped">
			<thead class="thead-inverse">
			  <tr>
			    <th>ID </th>
			    <th>Action</th>
			    <th>Username</th>
			    <th>Name</th>
			    <th>Email</th>
			    <th>Cellphone</th>
			    <th>Address</th>
			  </tr>
			</thead>
		  <tbody>
		  <?php if (isset($users) && sizeof($users) > 0) :?>
		  	<?php foreach ($users as $user) :?>
		  		<tr>
		  			<th scope="row"><?=$user->user_id ?></th>
		  			<td>
		  				<button type="button" id="add" class="btn btn-success">EDIT</button>
		  				<button type="button" id="add" class="btn btn-warning">DELETE</button>
		  			</td>
		  			<td><?= htmlspecialchars(strip_tags($user->user_name)) ?></td>
		  			<td><?=$user->full_name?></td>
		  			<td><?=$user->email?></td>
		  			<td><?=$user->contact?></td>
		  			<td><?=$user->address?></td>
		  		</tr>
		  	<?php endforeach ?>
		  <?php else: ?>
		  <i>No user is added yet.</i>
		  <?php endif ?>
		  </tbody>
		</table>
	</div>
	</div>
	<!-- invisible content -->
	<!-- Insert modal for users -->
	<div id="add_data_Modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4>Insert Date</h4>
				</div>
					<form class="form-horizontal well" action="user_approve.php" method="POST" id="insert_form">
				<div class="modal-body">
					    <!-- form content -->
					      <div class="form-group">
					        <label for="username">Username</label>
					        <input type="username" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter email">
					        <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
					      </div>
					      <div class="form-group">
					        <label for="password">Password</label>
					        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
					      </div>
					      <div class="form-group">
					        <label for="repassword">Re enter Password</label>
					        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Password">
					      </div>
					      <div class="form-group">
					        <label for="email">Email</label>
					        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
					      </div>
					      <div class="form-group">
					        <label for="fullname">Fullname</label>
					        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full name">
					      </div>

					      <div class="form-group">
					        <label for="address">Address</label>
					        <input type="textarea" class="form-control" id="address" name="address" placeholder="Address">
					      </div>

					      <div class="form-group">
					        <label for="contact">Contact</label>
					        <input type="tel" class="form-control" id="contact" name="contact" placeholder="Contact">
					      </div>
				</div>
				<div class="modal-footer">
							<button type="submit" class="btn btn-success btn-lg">Submit</button>
					<a href="#" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</a>
				</div>
					</form>
			</div>
		</div>		
	</div>

	<?php
	include 'includes/footer.php';
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#insert_form').on('submit',function(event){
			event.preventDefault();
			$.ajax({
				url: "user_approve.php",
				method:"POST",
				data:$('#insert_form').serialize(),
				success: function (data) {
					$('#insert_form')[0].reset();
					$('#add_data_Modal').modal('hide');
					$('#employee_table').html(data);
				}
			});
		});
	});
	</script>
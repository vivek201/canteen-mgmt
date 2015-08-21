<?php require 'includes/functions.php';?>
<?php include 'templates/header.php';?>
<?php include 'templates/navbar.php';?>
<?php $header = "accounts"; $page = "view";?>
<?php include 'templates/sidebar.php'?>
<div class="row" style="margin-right: 0">
	<div class="col-md-6 col-md-offset-3 page-wrapper">
		<h2>My Account Details</h2>
		<hr>
		<?php $user = User::select(array('id'=>$_SESSION['user_id'])); ?>
		<?php $emp = Employee::select(array('user_id' => $_SESSION['user_id'])); ?>
		<table class="table lead">
			<tr>
				<th>Name:</th>
				<td><?php echo $user->full_name(); ?></td>
			</tr>
			<tr>
				<th>Username:</th>
				<td><?php echo $user->username; ?></td>
			</tr>
			<tr>
				<th>Balance:</th>
				<td>Rs. <?php echo $emp->balance; ?></td>
			</tr>
			<tr>
				<th>Account Validity</th>
				<td><?php echo $emp->validity; 
					echo "<br>(";
					echo $emp->valid_days();
				?> days left)</td>
			</tr>
		</table>
	</div>
</div>

<?php include 'templates/footer.php';?>
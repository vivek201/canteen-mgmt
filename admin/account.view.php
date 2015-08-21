<?php require_once '../includes/functions.php';?>
<?php require_once 'templates/header.php';?>
<?php 
	$header = "accounts";
	$page = "view";
?>
<?php require_once 'templates/navbar.php';?>
<?php require_once 'templates/sidebar.php';?>
<?php
	$alertArray = array();
	if (isset($_GET['error']) && $_GET['error'] = 'same_ac')
		$alertArray['error'] = "<b>Sorry!</b> You cannot delete your own account.";
?>
<div class="row" style="margin-right: 0">
	<div class="col-md-8 col-md-offset-3 page-wrapper">
		<h2>View Existing Accounts</h2>
		<hr>
		<?php 
			echo bootstrap_alert($alertArray);
			$all_users = User::select();
			if (is_object($all_users))
				$all_users = array($all_users);
			if (!empty($all_users)) {
				$i = 1;
			?>
			<table class="table table-hover table-bordered">
				<tr>
					<th>S.N.</th>
					<th>Name</th>
					<th>Email</th>
					<th>Username</th>
					<th>A/C Type</th>
					<th>Actions</th>
				</tr>
				<?php foreach ($all_users as $user): ?>
				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo ucwords($user->full_name()); ?></td>
					<td><?php echo $user->email; ?></td>
					<td><?php echo $user->username; ?></td>
					<td><?php echo $user->permission; ?></td>
					<td>
						<a href="account.delete.php?id=<?php echo $user->id; ?>" class="btn btn-sm btn-danger">Delete</a>
						<?php if ($user->permission == 'EMPLOYEE'): ?>
						<a href="account.edit.php?id=<?php echo $user->id; ?>" class="btn btn-sm btn-default">Edit</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach;?>
			</table>
			<?php 
			}
		?>
	</div>
</div>
<?php require_once 'templates/footer.php';?>
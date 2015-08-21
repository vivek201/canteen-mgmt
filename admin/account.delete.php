<?php
	require '../includes/functions.php';
	require 'templates/header.php';
	if (isset($_POST['delete'])) {
		if (strtolower($_POST['delete']) == 'yes') {
			$condition = array('id' => $_POST['user_id']);
			$user = User::select($condition);
			if (is_object($user)) {
				if ($user->id != $session->user_id)
					$user->delete();
				else
// 					$alertArray['error'] = "<b>Sorry!</b> You cannot delete your own account!";
					redirect_to('account.view.php?error=same_ac');
			}
		}
	}
	
	
	if (!isset($_GET['id'])) {
		redirect_to('account.view.php');
	}
	
	if (isset($_GET['error']) && $_GET['error'] == 'delete') {
		$alertArray = array(
				'error' => 'The user could not be deleted!'
		);
	}
	
	$user = User::select(array('id' => $_GET['id']));
	// DISPLAY THE USER DETAILS AND THEN ASK FOR CONFIRMATION
	
	if ($user) {
// 		$user = $user[0];
		
		$header = "accounts";
		$page = "delete";
		require 'templates/navbar.php';
		require 'templates/sidebar.php';
		?>
		<div class="row" style="margin-right: 0">
			<div class="col-md-8 col-md-offset-3 page-wrapper">
				<h2>Delete Account</h2>
				<hr>
				<form class="form-horizontal" action="account.delete.php" method="post">
					<input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
					<div class="form-group">
					    <label class="col-sm-2 control-label">Username</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static"><?php echo $user->username; ?></p>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label class="col-sm-2 control-label">Name</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static"><?php echo ucwords($user->full_name()); ?></p>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label class="col-sm-2 control-label">Email</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static"><?php echo $user->email; ?></p>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label class="col-sm-2 control-label">Account Type</label>
					    <div class="col-sm-10">
					      	<p class="form-control-static"><?php echo $user->permission; ?></p>
					    </div>
				  	</div>
		
					<div class="well">
						<p>Do you really want to delete this account?</p>
						<div class="form-group">
							<input type="submit" value="Yes" name="delete" class="btn btn-danger" />
							<input type="submit" value="No" name="delete" class="btn btn-primary" />
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php
		require_once 'templates/footer.php';
	}
	else {
		redirect_to('account.view.php');
	}
?>
<?php require 'includes/functions.php';?>
<?php include 'templates/header.php';?>
<?php 
	$alertArray = array();
	if (isset($_POST['submit'])) {
		// CHECK IF THE OLD PASSWORD IS CORRECT
		$checkUser = User::select(array('username' =>$session->username, 'password' => md5($_POST['password'])));
		if ($checkUser) {
			// CHANGE THE PASSWORD OF THE USER
// 			var_dump($checkUser);
			$checkUser->password = md5($_POST['new_password']);
			$checkUser->update();
			$alertArray['success'] = 'The password has been succesfully changed!';
		}
		else {
			// THE OLD PASSWORD IS WRONG
			$alertArray['error'] = '<b>Oops!</b> The old password you entered is incorrect.';
		}
	}

?>
<?php include 'templates/navbar.php';?>
<?php $header = "accounts"; $page = "edit";?>
<?php include 'templates/sidebar.php'?>
<div class="row" style="margin-right: 0">
	<div class="col-md-6 col-md-offset-3 page-wrapper">
		<h2>Change Password</h2>
		<hr>
		<div id="error-div"></div>
		<?php echo bootstrap_alert($alertArray)?>
		<form class="form-horizontal" action="account.edit.php" method="post" onsubmit="return checkPassword();">
		  	<div class="form-group">
			    <label for="txtOldPassword" class="col-sm-4 control-label">Old Password</label>
			    <div class="col-sm-8">
			      	<input type="password" class="form-control" id="txtOldPassword" placeholder="Old Password" name="password" required>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="txtNewPassword" class="col-sm-4 control-label">New Password</label>
			    <div class="col-sm-8">
			      	<input type="password" class="form-control" id="txtNewPassword" placeholder="Password" name="new_password" required>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="txtReNewPassword" class="col-sm-4 control-label">Re-enter New Password</label>
			    <div class="col-sm-8">
			      	<input type="password" class="form-control" id="txtReNewPassword" placeholder="Password" required>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <div class="col-sm-offset-4 col-sm-8">
			      	<button type="submit" class="btn btn-primary" name="submit">Submit</button>
			    </div>
		  	</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	function checkPassword() {
		var password = document.getElementById('txtNewPassword').value;
		var repassword = document.getElementById('txtReNewPassword').value;
		if (password == repassword) {
			return true;
		}
		var errorDiv = document.getElementById('error-div');
		errorDiv.className = "alert alert-danger";
		errorDiv.innerHTML = "Please the enter new password twice";
		return false;
	}
</script>
<?php include 'templates/footer.php';?>
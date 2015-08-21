<?php require 'includes/functions.php';?>
<?php //include 'templates/header.php';?>
<?php 
	$session = new Session();
	$alertArray = array();

	if (isset($_GET['logout']) && $_GET['logout'] == true) {
		$session->logout();
	}
	
	if (isset($session->user_id)) {
		if ($session->permission == 'manager')
			redirect_to('admin/');
		elseif ($session->permission == 'staff')
			redirect_to('staff/');
		elseif ($session->permission == 'employee')
			redirect_to('account.view.php');
	}
	
	if (isset($_POST['submit'])) {
		$_POST['password'] = md5($_POST['password']);
		
		
		
		// if the username/password combination is in the database
		if ($user = User::select($_POST)) {
			// SET SESSION VARIABLE
			
			
			// ====
			if (strtolower($user->permission) == "employee") {
				$emp = Employee::select(array('user_id' => $user->id));
				if ($emp->valid_days() > 0) {
					$session->login($user);
					redirect_to("account.view.php");
				}
				else {
					$alertArray['error'] = "<b>Sorry!</b> Your account has been expired with a balance of Rs " . $emp->balance;
				}
			}
			elseif (strtolower($user->permission) == "staff") {
				$session->login($user);
				redirect_to("staff/");
			}
			elseif (strtolower($user->permission) == "manager") {
				$session->login($user);
				redirect_to("admin/");
			}
		}
		else {
			$alertArray['error'] = "<b>Sorry!</b> The username/password combination is incorrect.";
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Canteen Menu and Orderin</title>

    <!-- Bootstrap -->
<!--     <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
	<link href="assets/css/bootstrap-dark.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/fonts.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<div style="background-image: url('assets/images/foodfotto_blur.jpg'); height:100%; background-size: cover;">
	<div class="wrapper">
		<div class="wrapper-inner">
		<img alt="logo" src="assets/images/customer_img.png" class="img-responsive img-circle teset">
		<br>
		<form action="index.php" method="post" onsubmit="return required()">
			<?php bootstrap_alert($alertArray); ?>
			<div class="form-group">
				<input class="form-control input-lg" placeholder="Username" type="text" name="username" required maxlength="30" tabindex="1">
			</div>
			<div class="form-group">
				<input class="form-control input-lg" placeholder="Password" type="password" name="password" required maxlength="32" tabindex="2">
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary btn-block btn-lg" value="Sign In" name="submit" tabindex="3">
			</div>
		</form>
		</div>
	</div>
</div>
<?php include 'templates/footer.php';?>
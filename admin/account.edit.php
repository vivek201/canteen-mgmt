<?php require '../includes/functions.php';?>
<?php require 'templates/header.php';?>
<?php 
	$header = "accounts";
	$page = "edit";
?>
<?php require'templates/navbar.php';?>
<?php require 'templates/sidebar.php';?>
<?php	
	$alert_array = array();
	
	if (isset($_POST['submit'])) {
		$employee = new Employee();
		$employee->user_id = $_GET['id'];
		$employee->validity = $_POST['validity'];
		if ($employee->update('user_id')) {
			$alert_array['success'] = 'The account was successfully updated!';
		}
		else {
			$alert_array['error'] = 'The account was not updated!';
		}
	}
	
	if (isset($_GET['id']) && is_int(intval($_GET['id']))) {
		$id = intval($_GET['id']);
		$user = User::select(array('id' => $id));
		$employee = Employee::select(array('user_id' => $id));
		if (!$user || !$employee) {
			redirect_to('account.view.php');
		}
		
		if (isset($_GET['clearBalance']) && $_GET['clearBalance'] == 'Continue') {
			if (isset($_GET['deleteOrders']) && $_GET['deleteOrders'] == 'on') {
				$orders = Order::select(array('user_id' => $user->id));
				if (is_object($orders)) 
					$orders = array($orders);
				if (!$orders) {
					$alert_array['error'] = "The balance is already zero! ";
				}
				else {
				foreach ($orders as $order) 
					$order->delete();
				}
			}
			$employee->balance = 0;
			if ($employee->update('user_id') && !isset($alert_array['error'])) {
				$alert_array['success'] = 'The account was successfully updated!';
			}
			else {
				$alert_array['error'] .= 'The account was not updated!';
			}
		}
		?>
	
<div class="row" style="margin-right: 0px">
	<div class="col-md-8 col-md-offset-3 page-wrapper">
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-sm">
			    <div class="modal-content">
			      	<div class="modal-body">
			      		Are you sure?
						<form action="account.edit.php" method="get">
							<input type="hidden" name="id" value="<?php echo $id?>">
							<div class="checkbox">
								<label><input type="checkbox" name="deleteOrders" checked>Delete order details</label>
							</div>
							<input type="submit" class="btn btn-primary" value="Continue" name="clearBalance">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</form> 
			      	</div>
			    </div>
		  	</div>
		</div>
		<h2>Edit Account</h2>
		<hr>
		<form class="form-horizontal" action="account.edit.php?id=<?php echo $id;?>" method="post">
			<?php bootstrap_alert($alert_array); ?>
		  	<div class="form-group">
			    <label class="col-sm-2 control-label">Name</label>
			    <div class="col-sm-10">
			      	<p class="form-control-static"><?php echo $user->full_name(); ?></p>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label class="col-sm-2 control-label">Username</label>
			    <div class="col-sm-10">
			      	<p class="form-control-static"><?php echo $user->username; ?></p>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label class="col-sm-2 control-label">Balance</label>
			    <div class="col-sm-4">
			    	<p class="form-control-static">Rs. <?php echo $employee->balance; ?></p>
			    </div>
			    <div class="col-sm-2">
			    	<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal"
			    	<?php if ($employee->balance == 0) echo " disabled "?>
			    	>Clear Balance</button>
			    </div>
		  	</div>
		  	<div class="form-group">
			    <label for="dateValidity" class="col-sm-2 control-label">Valid Until</label>
			    <div class="col-sm-3">
			    	<input class="form-control" type="date" id="dateValidity" name="validity" value="<?php echo $employee->validity; ?>" />
			    </div>
		  	</div>
		  	<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-primary" name="submit">Update</button>
			    </div>
		  	</div>
		</form>
	</div>
</div>
	<?php 
	}
	else {
		redirect_to('account.view.php');
	}
?>
<?php require 'templates/footer.php';?>
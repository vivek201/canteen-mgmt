<?php require 'includes/functions.php';?>
<?php include 'templates/header.php';?>
<?php 
	$alertArray = array();
?>

<?php include 'templates/navbar.php';?>
<?php $header = "orders"?>
<?php include 'templates/sidebar.php';?>
<div class="row" style="margin-right: 0">
	<div class="col-md-6 col-md-offset-3 page-wrapper">
		<h2>My Orders</h2>
		<hr>
		<?php 
			$db = Database::getInstance();
			$stmt = $db->handle->prepare("SELECT DISTINCT date from orders WHERE user_id=? ORDER BY date DESC");
			if ($stmt->execute(array($session->user_id))) {
				$all_dates = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($all_dates)) {
					$i = 1;
					foreach ($all_dates as $row) {
						$orders = Order::select(array('date' => $row['date'], 'user_id' => $session->user_id));
						$tot = 0;
						?>
						<div class="panel-group" role="tablist">
						    <div class="panel panel-success">
						      	<div class="panel-heading" role="tab" id="collapseListGroupHeading<?php echo $i?>">
							        <h4 class="panel-title">
							          	<a class="collapsed center-block" data-toggle="collapse" href="#collapseListGroup<?php echo $i?>" aria-expanded="true" aria-controls="collapseListGroup<?php echo $i?>">
							            	<?php echo $row['date'] . "(" . strftime("%B %d, %Y",strtotime($row['date'])) . ")"; ?>
							          	</a>
							        </h4>
						      	</div>
						      	<div id="collapseListGroup<?php echo $i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading<?php echo $i?>" aria-expanded="true">
							        <table class="table table-bordered">
							        	<?php foreach ($orders as $order):
							        		$menuItem = MenuItem::select(array('id' => $order->menu_item_id));
							        	?>
							        	<tr>
							        		<td><?php echo $menuItem->name; ?></td>
							        		<td class="text-right"><?php echo $order->quantity; ?></td>
							        		<td class="text-right"><?php echo $menuItem->cost; ?></td>
							        		<td class="text-right"><?php $cur = $order->quantity * $menuItem->cost; $tot += $cur; echo $cur; ?></td>
							        	</tr>
							        	<?php endforeach;?>
							        </table>
						        	<div class="panel-footer">Total: <span class="pull-right">Rs. <?php echo $tot;?></span></div>
						      	</div>
						    </div>
					  	</div>
						<?php 
						$i++;
					}
					
				}
				else {
					$alertArray['success'] = "Looks like you haven't ordered anything yet! " .
							"<a class='alert-link' href='menu.view.php'>Order</a> Now!";
					bootstrap_alert($alertArray);
				}
			}
		?>
	</div>
</div>
<?php include 'templates/footer.php';?>
<script type="text/javascript">


document.body.onload = function() {
	$('.panel-collapse:first').collapse('show');
}

</script>
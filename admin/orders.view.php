<?php require '../includes/functions.php';?>
<?php include 'templates/header.php';?>
<?php 
	if (!isset($_GET['summary']) || ($_GET['summary'] != 'date' && $_GET['summary'] != 'user_id'))
		redirect_to('orders.view.php?summary=date');
	$summary = strtolower($_GET['summary']);
	
?>
<?php 
	$alertArray = array();
?>

<?php include 'templates/navbar.php';?>
<?php $header = "orders"; $page="view"?>
<?php include 'templates/sidebar.php';?>
<div class="row" style="margin-right: 0">
	<div class="col-md-6 col-md-offset-3 page-wrapper">
		<h2>
			All Orders (Summarized By 
			<a data-toggle="tooltip" data-placement="right" title="Click to Summarize by <?php echo ($summary == 'user_id') ? "Date": "Users"; ?>" 
			href="orders.view.php?summary=<?php echo ($summary == 'user_id') ? "date": "user_id"; ?>">
			<?php echo ($summary == 'user_id') ? "User": "Date"; ?></a>)
		</h2>
		<hr>
		<?php 
			$db = Database::getInstance();
			$sql = "SELECT DISTINCT $summary from orders ORDER BY $summary ";
			if ($summary == 'date')
				$sql .= "DESC";
			else 
				$sql .= "ASC";
			$stmt = $db->handle->prepare($sql);
			if ($stmt->execute()) {
				$all_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($all_rows)) {
					$i = 1;
					foreach ($all_rows as $row) {
						$orders = Order::select("SELECT id, menu_item_id, SUM(quantity) as quantity FROM orders WHERE $summary = '{$row[$summary]}' GROUP BY menu_item_id");
						$tot = 0;
						?>
						<div class="panel-group" role="tablist">
							<div class="panel panel-success">
						      	<div class="panel-heading" role="tab" id="collapseListGroupHeading<?php echo $i?>">
							        <h4 class="panel-title">
							          	<a class="collapsed center-block" data-toggle="collapse" href="#collapseListGroup<?php echo $i?>" aria-expanded="true" aria-controls="collapseListGroup<?php echo $i?>">
							            	<?php
							            		if ($summary == "user_id") {
							            			$user = User::select(array('id' => $row[$summary]));
							            			echo $user->full_name() . " (Username: " . $user->username .")";
							            		}
							            		else {
							            			echo $row[$summary];
							            			echo  "(" . strftime("%B %d, %Y",strtotime($row['date'])) . ")";
							            		}
							            	?>
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
					$alertArray['success'] = "Looks like nothing has been ordered yet! ";
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
	$('[data-toggle="tooltip"]').tooltip();
}

</script>
<?php require '../includes/functions.php'; ?>
<?php require 'templates/header.php'; ?>
<?php 
	if (isset($_GET['logout']) && $_GET['logout'] == "true") {
		$session->logout();
	}
	if (isset($_POST['submit'])) {
		foreach ($_POST['orders'] as $order) {
			$orderObj = new Order();
			$orderObj->id = $order;
			$orderObj->served = 1;
			$orderObj->date = '';
			$orderObj->update();
		}
	}
?>
<?php require 'templates/navbar.php'; ?>
<div class="row" style="margin-right: 0">
	<div class="col-md-8 col-md-offset-2 page-wrapper">
		<h2>Orders To Be Served Today<a id="hideButton" class="btn btn-info pull-right" data-toggle="collapse" data-target="#orderTable">Hide</a></h2>
		<hr>
		<?php 
			$sql = "SELECT menu_item.name, SUM(orders.quantity) AS quantity from orders " .  
					"INNER JOIN menu_item " . 
					"ON menu_item.id = orders.menu_item_id " . 
// 					"WHERE orders.date = '2015-08-12' " .
					"WHERE orders.date = '" . today() ."' AND orders.served = '0'" .
					"GROUP BY menu_item.name";
			$name_link = "name-asc";
			$quantity_link = "quantity-asc";
			if (isset($_GET['by'])) {
				switch ($_GET['by']) {
					case 'name-asc':
						$name_link = 'name-desc';
						$sql .= ' ORDER BY menu_item.name ASC';
						break;
					case 'name-desc':
						$name_link = 'name-asc';
						$sql .= ' ORDER BY menu_item.name DESC';
						break;
					case 'quantity-asc':
						$quantity_link = 'quantity-desc';
						$sql .= ' ORDER BY quantity ASC';
						break;
					case 'quantity-desc';
						$quantity_link = 'quantity-asc';
						$sql .= ' ORDER BY quantity DESC';
						break;
						
				}
			}
			else {
				redirect_to('index.php?by=name-asc');
			}
			
			$all_orders = Order::select($sql);
			if ($all_orders != 0) {
				if (is_object($all_orders)) {
					$all_orders = array($all_orders);
				}
				?>
				<div class="collapse in" id="orderTable" style="margin-bottom: 40px">
				<table class="table table-bordered">
					<tr>
						<th><a href="index.php?by=<?php echo $name_link; ?>" class="center-block">Item</a></th>
						<th><a href="index.php?by=<?php echo $quantity_link; ?>" class="center-block">Quantity</a></th>
					</tr>
					<?php foreach ($all_orders as $order):?>
					<tr>
						<td><?php echo $order->name; ?></td>
						<td><?php echo $order->quantity; ?></td>
					</tr>
					<?php endforeach;?>
				</table>
				</div>
				<div>
				<h2>Serve Order For </h2>
				<hr>
				<form class="form-inline" method="post" id="searchForm">
				  	<div class="form-group">
					    <label class="sr-only" for="txtUsername">Enter Username</label>
					    <div class="input-group">
					      	<input type="text" class="form-control" id="txtUsername" placeholder="Username" required>
					    </div>
					    <div class="input-group">
					      	<button type="submit" class="btn btn-primary" id="btnSearch"><span class="glyphicon glyphicon-search"></span></button>
					    </div>
				  	</div>
				</form>
				<br>
				<form action="<?php echo $_SERVER['REQUEST_URI']?>" method="post" id="serveForm" onsubmit="checkBoxes()">
				<table id="searchResults">
				</table>				
				</form>
				</div>
				<?php 
			}
			else {
				bootstrap_alert(array('error' => 'There are no orders today!'));
			}
		?>
	</div>
</div>

<?php require 'templates/footer.php'; ?>
<script type="text/javascript" src="/assets/js/staff.js"></script>
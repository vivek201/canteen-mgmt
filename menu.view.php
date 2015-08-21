<?php require 'includes/functions.php';?>
<?php include 'templates/header.php';?>
<?php 
	$alertArray = array();
	
	
	if (isset($_POST['submit'])) {
		// ADD THE TOTAL COST OF THE ORDER TO THE USER ACCOUNT BALANCE
		$total_cost = 0;
		foreach ($_POST as $key => $value) {
			if ($key != "submit") {
				if (!empty($value)) {
					$order = new Order();
					$order->menu_item_id = substr($key, 5);
					$order->quantity = $value;
					$order->user_id = $session->user_id;
					
					$old_order = Order::select(array(
							'menu_item_id' => substr($key, 5), 
							'user_id' =>$order->user_id, 
							'date' => today()
						));
					

					$menu_item = MenuItem::select(array('id' => $order->menu_item_id));
					
					// IF THE SAME ITEM HAS BEEN ORDERED TODAY, UPDATE THE ORDER
					if (is_object($old_order)) {
						$old_order->quantity += $value;
						//echo "<script>alert('update')</script>";
						if ($old_order->update()) {
							$alertArray['success'] = 'The order has been updated!';
							// ADD THE COST TO TOTAL COST
							$total_cost = $value * $menu_item->cost;
						}
						else 
							$alertArray['error'] = 'The items could not be ordered!';
					}
					// ELSE ADD THE ORDER
					else {
						//echo "<script>alert('update')</script>";
						if ($order->insert()) {
							$alertArray['success'] = 'The items have been added to your orders';
							$total_cost = $value * $menu_item->cost;
						}
						else 
							$alertArray['error'] = 'The items could not be ordered!';
					}
					if ($total_cost != 0) {
						$user = Employee::select(array('user_id' => $session->user_id));
						$user->balance += $total_cost;
						$user->update('user_id');
					}
				}
			}
		}
	}
?>
<?php include 'templates/navbar.php';?>
<?php $header = "menu"?>
<?php include 'templates/sidebar.php'?>

<div class="row" style="margin-right: 0">
	<div class="col-md-6 col-md-offset-3 page-wrapper">
		
		<h2>Today's Menu<a class="btn btn-default btn-sm pull-right" onclick="toggleAll(this)">Expand All</a></h2>
		<hr>
		<form action="menu.view.php" method="post">
		<?php echo bootstrap_alert($alertArray)?>
		<?php 
			$all_categories = MenuItemCategory::select();
			if (is_object($all_categories)) {
				$all_categories = array($all_categories);
			}
			if ($all_categories) {
				
				foreach ($all_categories as $category) {
					$menu_items = MenuItem::select(array('category_id' => $category->id, 'available' => '1'));
					if (is_object($menu_items)) {
						$menu_items = array($menu_items);
					}
					?>
			  	<div class="panel panel-primary">
			      	<div class="panel-heading" role="tab" id="collapseDivHead-<?php echo $category->id;?>">
				        <h4 class="panel-title">
				          	<a class="collapsed center-block" data-toggle="collapse" href="#collapseDiv-<?php echo $category->id;?>" aria-expanded="false" aria-controls="collapseDiv-<?php echo $category->id;?>">
				          		<?php echo ucwords($category->name);?>
				          	</a>
				        </h4>
			      	</div>
			      	<div id="collapseDiv-<?php echo $category->id;?>" class="panel-collapse menu collapse" role="tabpanel" aria-labelledby="collapseDivHead-<?php echo $category->id;?>">
				        <?php if (!empty($menu_items)):?>
			        	<table class="center-td table table-bordered">
			        		<tr>
			        			<th class="col-md-3">Item Name</th>
			        			<th class="col-md-2">Cost</th>
			        			<th class="col-md-7">Quantity</th>
		        			</tr>
		        			<?php foreach ($menu_items as $menu_item): ?>
		        			<tr>
		        				<td><?php echo $menu_item->name; ?></td>
		        				<td><?php echo $menu_item->cost; ?></td>
		        				<td>
		        				<div class="row">
		        					<div class="col-md-6">
	        							<input type="number" class="form-control" id="txtQuantity-<?php echo $menu_item->id;?>" name="item-<?php echo $menu_item->id; ?>" placeholder="E.g. 80" tabindex="1" min="0" step="<?php 
	        							if ($menu_item->halfs)
	        								echo "0.5";
	        							else 
	        								echo "1";
	        							
	        							?>" onchange="order(this)" />
        							</div>
		        					<div class="col-md-6 notice" id="info-<?php echo $menu_item->id?>"></div>
		        				</div>
		        				</td>
		        			</tr>
		        			<?php endforeach;?>
			        	</table><?php else:?>
			        	<div class="panel-body bg-danger">
			        	Sorry! Looks like there is nothing left today.
			        	</div>
			        	<?php endif;?>
			      	</div>
			    </div>
					
					<?php 
				}
				echo '
				<div class="form-group">
				
				<input type="submit" name="submit" value="Order" class="btn btn-primary">
				</div>';
			
		?>
		
		</form>
	</div>
	<div class="col-md-3 col-md-offset-9 page-wrapper fixed">
		<h2>My Orders</h2>
		<hr>
		<table id="showOrdersTable" class="table table-bordered ">
			<tr id="tblHeader">
				<th>Item</th>
				<th class="text-right">Quantity</th>
				<th class="text-right">Rate</th>
				<th class="text-right">Cost</th>
			</tr>
			<tbody></tbody>
			<tfoot id="tblFooter">
			</tfoot>
		</table>
	</div>
				<?php 
			}
			else {
				bootstrap_alert(array('error' => '<b>Sorry!</b>There is nothing on the menu today.'));
			}
	?>
</div>
<?php include 'templates/footer.php';?>

<script type="text/javascript">
	function order(t) {
		// CHECK IF VALUE IS LESS THAN 0
		// THEN IF YES SHOW INFO
		// AND SET THE HIDDEN CONTROL TO DISABLED=FALSE
		var id = t.getAttribute("id");
		var menuId = id.toString().split("-")[1];
		var info = document.getElementById('info-' + menuId);
		showOrder(t);
		if (t.value > 0) {
			info.innerHTML = "<span class='label label-primary' style='font-size:16px'>Added To Order</span>";
		}
		else {
			info.innerHTML = "";
		}
	}
	document.body.onload = function() {
		$('.panel-collapse:first').collapse('show');
	}

	function showOrder(t) {
		var table = document.getElementById('showOrdersTable').children[0];
		var tr = document.createElement("tr");
		var menuID = t.id.toString().split("-")[1];
		
		
		// IF VALUE IS 0, REMOVE THE RESPECTIVE TR
		if (t.value == '0') {
			if (temp = document.getElementById('td-' + menuID))
				temp.parentNode.removeChild(temp);
		}
		else {
			// CREATING CONTENT FOR THE TR
			var selfTD = t.parentNode.parentNode.parentNode;
			cost = selfTD.previousElementSibling;
			item = cost.previousElementSibling;
			
			var content = "<td>" + item.innerHTML + "</td><td class='text-right'>" + t.value + "</td><td class='text-right'>" + cost.innerHTML + "</td>";
			var tot_cost = t.value * cost.innerHTML;
			content += "<td class='totCost text-right'>" + tot_cost + "</td>";
			
			tr.id = "td-" + menuID;
			var oldTR = document.getElementById(tr.id);
			if (oldTR) {
				// IF OLD TR EXISTS, REPLACE THE CONTENT
				oldTR.innerHTML = content;
			}
			else {
				tr.innerHTML = content;
				table.appendChild(tr);
			}
		}

		var totalCost = 0;
		// IF THERE ARE ITEMS IN THE TABLE, THEN SHOW THE TOTAL COST
		var tds = table.getElementsByClassName('totCost')
		for (i = 0; i < tds.length; i++) {
			totalCost += parseInt(tds[i].innerHTML);
		}
		
		if (totalCost != 0) {
			var totalCostTR = document.getElementById('totalCostTR');
			if (totalCostTR == null) {
				totalCostTR = document.createElement("tr");
				totalCostTR.id = 'totalCostTR';
				document.getElementById('tblFooter').appendChild(totalCostTR);
			}
			totalCostTR.innerHTML = "<th colspan='3'>Total Cost</th><th class='text-right'>Rs. " + totalCost + "</th>";
		}
		else {
			if (temp = document.getElementById('totalCostTR')) {
				document.getElementById('tblFooter').removeChild(temp);
			}
		}
	}


	function toggleAll(t) {
		if (t.innerHTML == 'Expand All') {
			$('.menu').collapse('show');
			t.innerHTML = 'Hide All';
			t.className = 'btn btn-info btn-sm pull-right';
		}
		else if (t.innerHTML == 'Hide All') {
			$('.menu').collapse('hide');
			t.innerHTML = 'Expand All';
			t.className = 'btn btn-default btn-sm pull-right';
		}
	}
</script>
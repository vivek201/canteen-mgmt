<?php 
	require_once '../includes/functions.php';
	require 'templates/header.php';
	
	$header = "menu";
	$page = "view";
	require 'templates/navbar.php';
	require 'templates/sidebar.php';
	$alert = array();
	if (isset($_POST['submit'])) {
		// FIRSTLY SET ALL THE MENU ITEMS AS UNAVAILABLE
		$db = Database::getInstance();
		if (!$db->handle->query("UPDATE menu_item SET available = 0"))
			die("ERROR!");
		
		// UPDATE ALL THE MENU ITEMS RETURNED MAKING AVAILABLE 1
		if (isset($_POST['final_menu'])) {
			$selectedItems = $_POST['final_menu'];
			$itemObj = new MenuItem();
			foreach ($selectedItems as $key => $value) {
				$itemObj->id = $value;
				$itemObj->available = 1;
				$itemObj->update();
			}
		}
	}
	if (isset($_GET['success']) && $_GET['success'] == 'edit') {
		$alert['success'] = "The menu item was successfully updated.";
	}
?>
<div class="row" style="margin-right: 0">
	<div class="col-md-6 col-md-offset-3 page-wrapper">
		<h2>View Menu Item(s)</h2>
		<hr>
		<form action="menu.view.php" method="post">
		<h3>Today's Menu<a class="btn btn-default btn-sm pull-right" onclick="toggleAll('today-menu',this)">Expand All</a></h3>
		
		<hr>
		<?php 
			bootstrap_alert($alert);
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
			      	<div id="collapseDiv-<?php echo $category->id;?>" class="panel-collapse today-menu collapse" role="tabpanel" aria-labelledby="collapseDivHead-<?php echo $category->id;?>">
				        <?php if (!empty($menu_items)):?>
			        	<table class="table table-bordered table-hover">
			        		<tr>
			        			<th class="col-md-3">Item Name</th>
			        			<th class="col-md-1">Cost</th>
			        			<th class="col-md-2">Half Orders</th>
			        			<th class="col-md-3">Add to Today's Menu</th>
			        			<th class="col-md-3">Actions</th>
		        			</tr>
		        			<?php foreach ($menu_items as $menu_item): ?>
		        			<tr>
		        				<td><?php echo $menu_item->name; ?></td>
		        				<td><?php echo $menu_item->cost; ?></td>
		        				<td><?php echo ($menu_item->halfs) ? "Allowed" : "Not Allowed"; ?></td>
		        				<td>
		        				<label class="block-pointer">
		        					<input class="checkbox" type="checkbox" value="<?php echo $menu_item->id; ?>" name="final_menu[]" checked>
		        				</label>
		        				</td>
		        				<td>
		        				<a href="menu.edit.php?id=<?php echo $menu_item->id?>" class="btn btn-default btn-xs">Edit</a>
		        				<a href="menu.delete.php?id=<?php echo $menu_item->id?>" class="btn btn-danger btn-xs">Delete</a>
		        				</td>
		        			</tr>
		        			<?php endforeach;?>
			        	</table>
			        	<?php else:?>
			        	<div class="panel-body">
			        	<a>Add</a> a new item to Today's Menu
			        	</div>
			        	<?php endif;?>
			      	</div>
			    </div>
					
					<?php 
				}
			}
			else {
				bootstrap_alert(array('error' => 'No items to display.'));
			}
		?>
		<br />
		<h3>Other Menu Items<a class="btn btn-default btn-sm pull-right" onclick="toggleAll('remain-menu',this)">Expand All</a></h3>
		<hr>
		<?php 
			if ($all_categories) {
				foreach ($all_categories as $category) {
					$menu_items = MenuItem::select(array('category_id' => $category->id, 'available' => '0'));
					if (is_object($menu_items)) {
						$menu_items = array($menu_items);
					}
					?>
			  	<div class="panel panel-success">
			      	<div class="panel-heading" role="tab" id="collapseDivHeadUnav-<?php echo $category->id;?>">
				        <h4 class="panel-title">
				          	<a class="collapsed center-block" data-toggle="collapse" href="#collapseDivUnav-<?php echo $category->id;?>" aria-expanded="false" aria-controls="collapseDivUnav-<?php echo $category->id;?>">
				          		<?php echo ucwords($category->name);?>
				          	</a>
				        </h4>
			      	</div>
			      	<div id="collapseDivUnav-<?php echo $category->id;?>" class="panel-collapse remain-menu collapse" role="tabpanel" aria-labelledby="collapseDivHeadUnav-<?php echo $category->id;?>">
				        <?php if (!empty($menu_items)):?>
			        	<table class="table table-bordered table-hover">
			        		<tr>
			        			<th class="col-md-3">Item Name</th>
			        			<th class="col-md-1">Cost</th>
			        			<th class="col-md-2">Half Orders</th>
			        			<th class="col-md-3">Add to Today's Menu</th>
			        			<th class="col-md-3">Actions</th>
		        			</tr>
		        			<?php foreach ($menu_items as $menu_item): ?>
		        			<tr>
		        				<td><?php echo $menu_item->name; ?></td>
		        				<td><?php echo $menu_item->cost; ?></td>
		        				<td><?php echo ($menu_item->halfs) ? "Allowed" : "Not Allowed"; ?></td>
		        				<td>
		        				<label class="block-pointer">
		        					<input class="checkbox" type="checkbox" value="<?php echo $menu_item->id; ?>" name="final_menu[]" >
		        				</label>
	        					</td>
	        					<td>
		        				<a href="menu.edit.php?id=<?php echo $menu_item->id?>" class="btn btn-default btn-xs">Edit</a>
		        				<a href="menu.delete.php?id=<?php echo $menu_item->id?>" class="btn btn-danger btn-xs">Delete</a>
		        				</td>
		        			</tr>
		        			<?php endforeach;?>
			        	</table>
			        	<?php else:?>
			        	<div class="panel-body">
			        	<a href="menu.add.php">Add</a> a new menu item
			        	</div>
			        	<?php endif;?>
			      	</div>
			    </div>
					
					<?php 
				}
			}
			else {
				bootstrap_alert(array('error' => 'No items to display.'));
			}
		?>
		<?php //if (isset($_POST['submit'])) var_dump($selectedItems); ?>
		<div class="fixed-right">
				<input type="submit" name="submit" value="Save Menu" class="btn btn-primary" id="btnSubmit">
		</div>
		</form>
	</div>
</div>
<?php require_once 'templates/footer.php';?>
<script type="text/javascript">

	document.body.onload = function() {
		$('.panel-collapse:first').collapse('show');
	}

	function toggleAll(which, t) {
		if (t.innerHTML == 'Expand All') {
			$('.' + which).collapse('show');
			t.innerHTML = 'Hide All';
			t.className = 'btn btn-info btn-sm pull-right';
		}
		else if (t.innerHTML == 'Hide All') {
			$('.' + which).collapse('hide');
			t.innerHTML = 'Expand All';
			t.className = 'btn btn-default btn-sm pull-right';
		}
	}
</script>
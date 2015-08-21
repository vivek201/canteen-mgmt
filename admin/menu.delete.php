<?php
	require '../includes/functions.php';
	require 'templates/header.php';
	if (isset($_POST['delete'])) {
		if (strtolower($_POST['delete']) == 'yes') {
			
			$menuItem = MenuItem::select(array('id' => $_POST['menu_item_id']));
			if (is_object($menuItem)) {
				$menuItem->delete();
				// IF THE CATEGORY HAS NO MORE ITEMS DELETE THE CATEGORY AS WELL
				if (MenuItem::count("category_id ='". $menuItem->category_id . "'") == 0) {
					$menuCat = new MenuItemCategory();
					$menuCat->id = $menuItem->category_id;
					$menuCat->delete();
				}
			}
			else {
				redirect_to("menu.view.php?error=1");
			}
		}
	}
	
	
	if (!isset($_GET['id'])) {
		redirect_to('menu.view.php');
	}
	
	if (isset($_GET['error']) && $_GET['error'] == 'delete') {
		$alertArray = array(
				'error' => 'The menu item could not be deleted!'
		);
	}
	
	$menuItem = MenuItem::select(array('id' => $_GET['id']));
	// DISPLAY THE USER DETAILS AND THEN ASK FOR CONFIRMATION
	
	if (is_object($menuItem)) {
		
		$header = "menu";
		$page = "delete";
		require 'templates/navbar.php';
		require 'templates/sidebar.php';
		?>
		<div class="row" style="margin-right: 0">
			<div class="col-md-8 col-md-offset-3 page-wrapper">
				<h2>Delete Menu Item</h2>
				<hr>
				<form class="form-horizontal" action="menu.delete.php" method="post">
					<input type="hidden" name="menu_item_id" value="<?php echo $menuItem->id; ?>">
					<div class="form-group">
					    <label class="col-sm-2 col-xs-4 control-label">Item Name</label>
					    <div class="col-sm-10 col-xs-8">
					      	<p class="form-control-static"><?php echo $menuItem->name; ?></p>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label class="col-sm-2 col-xs-4 control-label">Cost</label>
					    <div class="col-sm-10 col-xs-8">
					      	<p class="form-control-static"><?php echo $menuItem->cost; ?></p>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label class="col-sm-2 col-xs-4 control-label">Item Category</label>
					    <div class="col-sm-10 col-xs-8">
					      	<p class="form-control-static">
					      	<?php
					      		$cat = MenuItemCategory::select(array('id' => $menuItem->category_id));
					      		echo ucwords($cat->name);
				      		?>
					      	</p>
					    </div>
				  	</div>
					<div class="well">
						<p>Deleting the item will also delete all the orders of this item. Do you wish to continue?</p>
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
		redirect_to('menu.view.php');
	}
?>
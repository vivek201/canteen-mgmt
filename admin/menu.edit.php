<?php 
	require_once '../includes/functions.php';
	require 'templates/header.php';
	
	$header = "menu";
	$page = "edit";
	require 'templates/navbar.php';
	require 'templates/sidebar.php';
	$alert = array();
	if (isset($_POST['submit'])) {
		$menu_item = new MenuItem();
		$menu_item->instantiate($_POST);
		if (isset($_POST['halfs']))
			$menu_item->halfs = true;
		else
			$menu_item->halfs = false;
		if ($menu_item->update())
			redirect_to('menu.view.php?success=edit');
		else
			redirect_to('menu.view.php?error=edit');
	}
	
	
	
	
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
		$menu_item = MenuItem::select(array('id' => $id));
		if (!is_object($menu_item)) 
			redirect_to('menu.view.php');

?>
<div class="row" style="margin-right: 0">
	<div class="col-md-6 col-md-offset-3 page-wrapper">
		<h2>Add New Menu Item</h2>
		<hr>
		<form action="menu.edit.php" method="post" autocomplete="off">
			<input type="hidden" name="id" value="<?php echo $id;?>" />
			<?php bootstrap_alert($alert); ?>
			<div class="row">
				<div class="form-group col-md-6">
					<label for="txtItemName">Item Name:</label>
					<input type="text" class="form-control" id="txtItemName" name="name" placeholder="E.g. Buff Momos" tabindex="1" required value="<?php echo $menu_item->name; ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="txtCost">Cost:</label>
					<input type="number" class="form-control" id="txtCost" name="cost" placeholder="E.g. 80" tabindex="1" min="0" step="0.01" required value="<?php echo $menu_item->cost?>">
				</div>
			</div>
			<div class="form-group">
			    <label for="selectCategory">Menu Item Category</label>
			    <select class="form-control" id="selectCategory" name="category_id" tabindex="4" required>
					<?php 
						$allMenuCat = MenuItemCategory::select();
						if (is_object($allMenuCat))
							$allMenuCat = array($allMenuCat);
						foreach ($allMenuCat as $menuCat) {
							echo "<option value='$menuCat->id'>". ucwords($menuCat->name) ."</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group hidden" id="newCatDiv">
				<label for="txtCategory">Category Name</label>
				<input type="text" class="form-control" id="txtCategory" name="menuCategory" placeholder="Enter the new category" tabindex="5">
			</div>
			<div class="checkbox">
				<label>
				<input type="checkbox" name="halfs" tabindex="5"/>	Allow half orders
				</label>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" value="update" tabindex="5">Add Item</button>
		</form>
	</div>
</div>
	<?php 
	}
	else {
		redirect_to('menu.view.php');
	}
?>
<?php require_once 'templates/footer.php';?>
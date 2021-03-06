<?php 
	require_once '../includes/functions.php';
	require 'templates/header.php';
	
	$header = "menu";
	$page = "add";
	require 'templates/navbar.php';
	require 'templates/sidebar.php';
	$alert = array();
	if (isset($_POST['submit'])) {
		$menu = new MenuItem();
		$menu->instantiate($_POST);
		if (!empty($menu->halfs))
			$menu->halfs = '1';
		if ($menu->category_id == "#add") {
			$menuCat = new MenuItemCategory();
			$menuCat->name = $_POST['menuCategory'];
			$menuCat->insert();
			$menu->category_id = $menuCat->id;
			
		}
		if ($menu->insert())
			$alert['success'] = "The menu item has been added!";
		else 
			$alert['error'] = "The menu item could not be added!";
	}
?>

<div class="row" style="margin-right: 0">
	<div class="col-md-6 col-md-offset-3 page-wrapper">
		<h2>Add New Menu Item</h2>
		<hr>
		<form action="menu.add.php" method="post" autocomplete="off" onsubmit="return required()">
			
			<?php bootstrap_alert($alert); ?>
			<div class="row">
				<div class="form-group col-md-6">
					<label for="txtItemName">Item Name:</label>
					<input type="text" class="form-control" id="txtItemName" name="name" placeholder="E.g. Buff Momos" tabindex="1" required>
				</div>
				<div class="form-group col-md-6">
					<label for="txtCost">Cost:</label>
					<input type="number" class="form-control" id="txtCost" name="cost" placeholder="E.g. 80" tabindex="1" min="0" step="0.01" required>
				</div>
			</div>
			<div class="form-group">
			    <label for="selectCategory">Menu Item Category</label>
			    <select class="form-control" id="selectCategory" name="category_id" tabindex="4" onchange="checkNew()" required>
					<?php 
						$allMenuCat = MenuItemCategory::select();
						if (is_object($allMenuCat))
							$allMenuCat = array($allMenuCat);
						foreach ($allMenuCat as $menuCat) {
							echo "<option value='$menuCat->id'>". ucwords($menuCat->name) ."</option>";
						}
					?>
					<option value="#add">Add New Category</option>
				</select>
			</div>
			<div class="form-group hidden" id="newCatDiv">
				<label for="txtCategory">Category Name</label>
				<input type="text" class="form-control" id="txtCategory" name="menuCategory" placeholder="Enter the new category" tabindex="5">
			</div>
			<div class="checkbox">
				<label>
				<input type="checkbox" name="halfs" />	Allow half orders
				</label>
			</div>
			<button type="submit" class="btn btn-primary" name="submit" value="add" tabindex="5">Add Item</button>
		</form>
		<?php 

		if (isset($_POST['submit'])) {
			// dumper
		}
		
		?>
	</div>
</div>

<script type="text/javascript">

function checkNew(){
	var select = document.getElementById('selectCategory');
	var div = document.getElementById('newCatDiv');
	var input = document.getElementById('txtCategory');
	if (select.options[select.selectedIndex].value == "#add") {
		div.className = "form-group";
		input.required = true;
	}
	else {
		div.className = "form-group hidden";
		input.required = false;
	}
}

checkNew();
</script>	
<?php require_once 'templates/footer.php';?>
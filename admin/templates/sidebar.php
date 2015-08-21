<div class="sidebar">
  	<ul class="nav nav-pills nav-stacked">
	  	<li>
	  		<a href="account.add.php">Manage Accounts</a>
	  		<?php if ($header == "accounts"): ?>
	  		<ul class="nav nav-pills nav-stacked sub-menu">
	  			
	  			<li <?php echo ($page == "add") ? "class='active'" : "" ; ?>><a href="account.add.php">Add Accounts</a></li>
	  			<li <?php echo ($page == "view") ? "class='active'" : "" ; ?>><a href="account.view.php">View Accounts</a></li>
	  			<?php if ($page == "delete"): ?><li class="active"><a href="#">Delete Account</a></li><?php endif;?>
	  			<?php if ($page == "edit"): ?><li class="active"><a href="#">Edit Account</a></li><?php endif;?>
	  		</ul>
	  		<?php endif; ?>
	  	</li>
	  	<li>
	  		<a href="menu.add.php">Menu</a>
	  		<?php if ($header == "menu"): ?>
	  		<ul class="nav nav-pills nav-stacked sub-menu">
	  			<li <?php echo ($page == "add") ? "class='active'" : "" ; ?>><a href="menu.add.php">Add Menu Item</a></li>
	  			<li <?php echo ($page == "view") ? "class='active'" : "" ; ?>><a href="menu.view.php">View Menu Items</a></li>
	  			<?php if ($page == "delete"): ?><li class="active"><a href="#">Delete Menu Item</a></li><?php endif; ?>
	  			<?php if ($page == "edit"): ?><li class="active"><a href="#">Edit Menu Item</a></li><?php endif; ?>
	  		</ul>
	  		<?php endif; ?>	
  		</li>
	  	<li>
	  		<a href="orders.view.php">Orders</a>
	  		<?php if ($header == "orders"): ?>
	  		<ul class="nav nav-pills nav-stacked sub-menu">
	  			<li <?php echo ($page == "view") ? "class='active'" : "" ; ?>><a href="#">View All Orders</a></li>
	  			<?php if ($page == "delete"): ?><li class="active"><a href="#">Delete Menu Item</a></li><?php endif; ?>
	  			<?php if ($page == "edit"): ?><li class="active"><a href="#">Edit Menu Item</a></li><?php endif; ?>
	  		</ul>
	  		<?php endif; ?>	
  		</li>
	  	<!-- li <?php //if ($header == "help") echo "class='active'"; ?>><a href="admin_help_page.php">Help</a></li -->
	</ul>
</div>
<div class="sidebar">
  	<ul class="nav nav-pills nav-stacked">
<!-- 	  	<li> -->
<!-- 	  		<a href="account.view.php">My Account</a> -->
	  		<?php //if ($header == "accounts"): ?>
<!-- 	  		<ul class="nav nav-pills nav-stacked sub-menu"> -->
<!--   			<li <?php //echo ($page == "view") ? "class='active'" : "" ; ?>><a href="account.view.php">View Account Details</a></li> -->
<!--  	  			<li <?php //echo ($page == "edit") ? "class='active'" : "" ; ?>><a href="account.edit.php">Change Password</a></li> -->
<!-- 	  		</ul> -->
	  		<?php //endif; ?>
<!-- 	  	</li> -->
<!-- <li <?php //if ($header == "menu") echo "class='active'"; ?>><a href="menu.view.php">Today's Menu</a></li> -->	  	
	  	
	  	<li <?php if ($header == "orders") echo "class='active'"; ?>><a href="orders.view.php">My Orders</a></li>
	</ul>
</div>
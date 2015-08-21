<?php 
	require_once '../includes/functions.php';
	require_once 'templates/header.php';
	if (isset($_GET['logout']) && $_GET['logout'] == true)
		$session->logout();
	redirect_to('account.add.php');
	$header = "help";
	require_once 'templates/navbar.php';
	require_once 'templates/sidebar.php';
	require_once 'templates/footer.php';

?>
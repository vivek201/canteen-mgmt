<?php
	function __autoload($class_name) {
		require $_SERVER['DOCUMENT_ROOT'] . '/app/' . $class_name . '.class.php';
	}
	
	function bootstrap_alert($alertArray) {
		
		if (isset($alertArray['error'])) {
			$alertType = 'danger';
			$alertMsg = $alertArray['error'];
		}
		else if (isset($alertArray['success'])){
			$alertType = 'info';
			$alertMsg = $alertArray['success'];
		}
		else {
			return;
		}
		
		echo '<div class="alert alert-' . $alertType . '" role="alert">' . $alertMsg . '</div>';
	}
	

	function redirect_to($loc = NULL) {
		header("Location: " . $loc);
		exit();
	}
	
	function today() {
		date_default_timezone_set('Asia/Kathmandu');
		return date('Y-m-d', strtotime('today'));
	}
?>
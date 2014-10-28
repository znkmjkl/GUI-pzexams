<?php
	// include_once("../../lib/Lib.php");
	include_once("../../lib/Lib.php");
	header("content-type:application/json");
	
	$domainExistsJSON    = array('status' => 'dataRecived', 'domain' => 'exists');
	$domainNotExistsJSON = array('status' => 'dataRecived', 'domain' => 'notExists');
	
	if (isset($_POST['email'])) {
		$domains = Settings::getDomains();
		if ($domains == null) {
			echo json_encode($domainExistsJSON);
			return;
		}
		
		$wantedDomain = substr($_POST['email'], strpos($_POST['email'], '@') + 1, strlen($_POST['email']));
		
		foreach ($domains as $domain) {
			if ("$wantedDomain" == "$domain") {
				echo json_encode($domainExistsJSON);
				return;
			}
		}
		
		echo json_encode($domainNotExistsJSON);
	}
?>

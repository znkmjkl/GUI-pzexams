<?php
	include_once("../Lib.php");

	header("content-type:application/json");

	sleep(2);
	
	echo json_encode(array("status" => "success", "errorMsg" => "", "send" => "0"));
	return;

?>

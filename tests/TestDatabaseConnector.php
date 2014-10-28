<?php
	include("TestBegin.php");
	
	include_once('../lib/Lib.php');
			
	if (DatabaseConnector::isConnected()) {
		echo "Połączenie z bazą danych działa poprawnie. <br \>\n";
	} else {
		
	}
	
	include("TestEnd.php");
?>

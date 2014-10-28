<?php
	include("TestBegin.php");
	
	include_once('../lib/Lib.php');
	
	$user = UserDatabase::getUser(1);
	if ($user == null) {
		echo "Następujący test zakończył się niepowodzeniem: \"UserDatabase::getUser(1);\"" . "<br \>";
		echo DatabaseConnector::getLastError();
	}
	else {
		if ( $user->getEmail() == "test@uj.edu.pl"   ) {  
			echo "Następujący test zakończył się powodzeniem: \"UserDatabase::getUser(1);\"" . "<br \>";
		} else { 
			echo "Następujący test zakończył się niepowodzeniem: \"UserDatabase::getUser(1);\"" . "<br \>";
		}
	}
	
	/* TODO: Wypisywać wszystkie informację o aktualnie zalogowanym użytkowniku */
	
	include("TestEnd.php");
	
?>

<?php
	
	include_once("../lib/Lib.php");
	
	if (isset($_POST['submitActivationCodeButton']) 
		&& isset($_POST['activationCode']) 
		&& $_POST['activationCode'] == Settings::getAuthorizationCode()  
		) { 
		$_SESSION['codeActivationStepCompleted'] = 'stepCompleted' ; 
		header('Location: ../RegisterForm.php' ); 
	} else {
		$_SESSION['codeActivationStepCompleted'] = 'stepIncompleted' ; 
		$_SESSION['activationCodeFormErrorCode'] = 'invalidActivationCode';
		header('Location: ../InsertActivationCode.php'); 
	}
	
?>

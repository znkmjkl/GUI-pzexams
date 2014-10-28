<?php
include_once("../lib/Lib.php");
echo $_POST['email'];

if(isset($_POST['email']) && $_POST['email'] != ''){
	$basicUser = new basicUser();
	$basicUser->setEmail($_POST['email']);

	if(UserDatabase::checkEmail($basicUser)){
		$newPassword = substr(md5(microtime()),0,8);
		if(UserDatabase::updateUserPassword2($basicUser,$newPassword)){						
			$Url = "http://" . Settings::getAdress() . "/index.php";
			$messageBody = 
					"Witaj!<br/><br/>" .
					"Twoje nowe hasło to: <b>". $newPassword ."</b>.<br/><br/>" .
					"Możesz je później zmienić w ustawieniach Twojego konta <br/>".
					"Zapraszamy na serwis:" .
					"<a href=\"" . $Url  . "\">" . $Url  . "</a><br/><br/>" .
					"______________________________<br/>" .
					"Pozdrawiamy - zespół PZ-Exams<br/>";
			
							
				if(!mailer($basicUser->getEmail(),'cos nieistotnego',"PZ-Exams", "Odzyskiwanie hasła", $messageBody, true)){
					$_SESSION['forgottenPass'] = "emailError";
					header('Location: ../ForgottenPassword.php');
				}
				$_SESSION['forgottenPass'] = 'success';
				header('Location: ../index.php');				
		} else {
			$_SESSION['forgottenPass'] = "updateError";
			header('Location: ../ForgottenPassword.php');
		}
	} else {
		$_SESSION['forgottenPass'] = "noEmailInDB";
		header('Location: ../ForgottenPassword.php');
	}
}


?>
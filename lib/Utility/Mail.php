<?php
	include_once("Mail/PHPMailerAutoload.php");
	
	include_once(__DIR__ . "/../General/Settings.php");
	
	/***
	 * Jako pierwszy argument można podać jednego adresata, lub tablicę
	 * bool $isHTML - czy tresc e-maila ($body) zawiera znaczniki HTML,
	 * ktore maja zostac sparsowane.
	 */
	function mailer($to, $from, $from_name, $subject, $body, $isHTML) {
		global $error;
		$mail = new PHPMailer();
		
		if (gettype($to) == 'array') {
			foreach ($to as $address) {
				$mail->AddAddress($address);
			}
		} else {
			$mail->AddAddress($to);
		}
	
		$from = Settings::getEmailAdress();
		
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = Settings::getEmailHost();
		$mail->Port = Settings::getEmailPort();
		$mail->Username = Settings::getEmailAdress();
		$mail->Password = Settings::getEmailPassword();
		$mail->SetFrom($from, $from_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->IsHTML($isHTML);
		$mail->CharSet = 'UTF-8';
		
		if(!$mail->Send()) {
			$error = 'Mail error: ' . $mail->ErrorInfo; 
			//tutaj bedzie dostepny kod bledu
			$_SESSION['mailerErrorInfo']=$mail->ErrorInfo;
			//die('Error: '.$mail->ErrorInfo);
			return false;
		} else {
			$error = 'Message sent!';
			// echo 'Poszlo';
			//die('OK');
			$mail->ClearAllRecipients();
			return true;
		}
	}
	
?>

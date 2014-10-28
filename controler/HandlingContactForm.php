<?php
require_once '../lib/SecureImage/securimage.php';
include_once "../lib/Lib.php";
require_once '../lib/Utility/Mail.php';
require_once '../lib/General/Settings.php';

$captcha_code        = $_POST['captcha_code'];

$securimage = new Securimage();

if ($securimage->check($captcha_code) == true) {
	if (empty($_POST['email'])) {
		//puste pole email
		echo 'brak maila';
	} else { 
		//zapisz email
		$cMail=$_POST['email'];
	}
  
	if (empty($_POST['subject'])){
		//pusty temat
		echo 'brak tematu';
	} else {
		//zapisz temat
		$cSubject=$_POST['subject'];
	}
  
  	if (empty($_POST['surname'])){
  		echo 'brak imienia i nazwiska';
  	} else {
  		$cSurname=$_POST['surname'];
  	}
  
	if (empty($_POST['message'])){
		//pusta wiadomosc
		echo 'brak wiadomosc';
	} else {
		//zapisz wiadomosc
		$cMessage=$_POST['message'];
		$cMessage=$cMessage."\n---------------------------------------------------\n".'Email: '.$cMail."\nImię i Nazwisko: ".$cSurname;
	}
 
	echo 'captcha code valid'; 
  
	//cMail - adres podany w formularzy
	//cSubject - temat podany w formularzu
	//cMessage - tresc komunikatu
	if(mailer(Settings::getEmailAdress(),$cMail,'Formularz kontaktowy',$cSubject,$cMessage,false)){
		$_SESSION['successContactForm'] = 'mailerSuccess';
	}else{
		$_SESSION['contactFormErrorCode'] = 'mailerError';
	}
} else {
	$_SESSION['contactFormErrorCode'] = 'invalidCaptcha';
}

header('Location: ../Contact.php' );
;?>

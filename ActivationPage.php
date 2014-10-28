<?php
	include_once("lib/Lib.php");

	$title = "$appName";
	include("html/Begin.php");

	if (isset($_GET['email'], $_GET['code']) === true) {
		$email = trim($_GET['email']);
		$code = trim($_GET['code']);

		$user = new User();
		$user->setEmail($email);

		if (UserDatabase::checkEmail($user) === false) {
			echo '<h4>Nie znaleziono adresu e-mail.</h4>';
		} else if (UserDatabase::activate($email, $code) === false) {
			echo '<h4>Wystąpił problem podczas aktywacji konta.</h4>';
		}
		else {
			echo '<h4>Twoje konto zostało aktywowane. Od tej chwili możesz się zalogować w serwisie.</h4>';
		}
	} else {
		header('Location: index.php');
		exit();
	}

?> 



<?php include("html/End.php"); ?>

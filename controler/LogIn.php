<?php
	include("../lib/Lib.php");

	if(isset($_POST['email']) && isset($_POST['pass'])) {
		$email = $_POST['email'];
		$pass = sha1($_POST['pass']);

		$basicUser = new basicUser();
		$basicUser->setEmail($email);
		$basicUser->setPassword($pass);
		/*echo $pass;
		echo "<br/>";
		echo md5($pass);*/
		if (UserDatabase::checkEmail($basicUser)) {
			if (UserDatabase::checkPassword($basicUser)) {
				if (UserDatabase::checkActivated($basicUser)) {
					$_SESSION['USER'] = serialize($basicUser);
					header('Location: ../UserSite.php');
				} else {
					$_SESSION['ERROR'] = 3;
					header('Location: ../index.php');
				}
			} else {
				$_SESSION['ERROR'] = 2;
				header('Location: ../index.php');
			}
		} else {
			$_SESSION['ERROR'] = 1;
			header('Location: ../index.php');
		}
	} else {
		header('Location: ../index.php');
	}
?>

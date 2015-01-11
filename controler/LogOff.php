<?php
	session_destroy();
	session_start();
	$_SESSION['USER'] = "";
	$_SESSION['logoutSuccess'] = "true";
	header('Location: ../index.php');
?>
